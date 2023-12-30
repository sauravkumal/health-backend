<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Entities\WebhookInfo;
use Longman\TelegramBot\Request;

class ConfigureTelegramWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:configure-telegram-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure telegram webhook';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $option = $this->choice('Please select any option', [
            'Webhook Info',
            'Register webhook',
            'Remove webhook'
        ]);

        match ($option) {
            'Webhook Info' => $this->webhookInfo(),
            'Register webhook' => $this->registerWebhook(),
            'Remove webhook' => $this->removeWebhook()
        };

        return Command::SUCCESS;
    }

    private function webhookInfo(): void
    {
        /* @var WebhookInfo $response */
        $response = Request::getWebhookInfo()->getResult();
        $this->info('Current webhook url is: ' . $response->getUrl());

        $this->info('Allowed updated are: ' . collect($response->getAllowedUpdates())->join(', ', ' and '));
    }

    private function registerWebhook(): void
    {
        $webhookUrl = $this->ask('Enter telegram webhook url', env('APP_URL'));
        $webhookUrl = trim($webhookUrl, "/");

        $response = Request::setWebhook([
            'url' => $webhookUrl . '/api/webhook',
            'allowed_updates' => [
                Update::TYPE_CALLBACK_QUERY,
                Update::TYPE_CHOSEN_INLINE_RESULT,
                Update::TYPE_INLINE_QUERY,
                Update::TYPE_MESSAGE,
            ]
        ]);
        if ($response->isOk()) {
            $this->info($response->getProperty('description'));

        } else {
            $this->error($response->getProperty('description'));
        }


    }

    private function removeWebhook(): void
    {
        $response = Request::deleteWebhook(['drop_pending_updates' => true]);
        if ($response->isOk()) {
            $this->info($response->getProperty('description'));
        } else {
            $this->error($response->getProperty('description'));
        }
    }
}
