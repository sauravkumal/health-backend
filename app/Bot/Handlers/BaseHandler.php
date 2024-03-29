<?php

namespace App\Bot\Handlers;

use App\Bot\Commands\System\CallbackqueryCommand;
use Illuminate\Support\Str;
use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\Chat;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Entities\User;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class BaseHandler
{

    protected Command $command;

    protected Conversation $conversation;

    protected $conversationNotes;

    protected $conversationState;


    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @throws TelegramException
     */
    protected function replyText($text): ServerResponse
    {
        return $this->reply(['text' => $text]);
    }

    /**
     * @throws TelegramException
     */
    protected function reply($data): ServerResponse
    {
        $data['chat_id'] = $this->chatId();
        $data['parse_mode'] = 'HTML';
        return Request::sendMessage($data);
    }

    protected function chat(): Chat
    {
        if ($this->command instanceof CallbackqueryCommand) {
            return $this->command->getCallbackQuery()->getMessage()->getChat();
        }
        return $this->command->getMessage()->getChat();
    }

    protected function chatId(): int
    {
        return $this->chat()->getId();
    }

    protected function from(): User
    {
        if ($this->command instanceof CallbackqueryCommand) {
            return $this->command->getCallbackQuery()->getFrom();
        }
        return $this->command->getMessage()->getFrom();
    }

    protected function messageText(): string
    {
        if ($this->command instanceof CallbackqueryCommand) {
            $callbackData = $this->command->getCallbackQuery()->getData();
            $split = explode('_', $callbackData);
            return end($split);
        }
        return trim($this->command->getMessage()->getText(true));
    }

    /**
     * @throws TelegramException
     */
    protected function initConversation($identifier): void
    {
        $this->conversation = new Conversation($this->from()->getId(), $this->chatId(), $identifier);

        $this->conversationNotes = &$this->conversation->notes;
        !is_array($this->conversationNotes) && $this->conversationNotes = [];
        $this->conversationState = $this->conversationNotes['state'] ?? 0;
    }

    protected function updateConversation(): bool
    {
        return $this->conversation->update();
    }

    /**
     * @throws TelegramException
     */
    protected function stopConversation(): void
    {
        $this->conversation->stop();
    }

    protected function setState($state): void
    {
        $this->conversationNotes['state'] = $state;
        $this->conversationState = $state;
        $this->updateConversation();
    }

    protected function setNote($key, $value): void
    {
        $this->conversationNotes[$key] = $value;
    }

    protected function getNote($key)
    {
        return $this->conversationNotes[$key] ?? false;
    }

    protected function scoped($value, $handler = null): string
    {
        return Str::of($handler ?? get_class($this))
            ->remove(["App\\Bot\\Handlers\\", 'Handler'])->append('_', $value)->value();
    }
}
