# vConnect Delayed AMQP Example

## Purpose

This extension provides an example of a working Magento 2 module that uses the delayed messages feature.

## Pre-conditions
1. The extension requires the `vconnect/module-delayed-amqp` [package](https://github.com/vConnect-dk/delayed-amqp) to be installed to work properly.
2. Your Magento 2 environment should have a RabbitMQ connection configured.
3. The [RabbitMQ Delayed Message Plugin](https://www.rabbitmq.com/blog/2015/04/16/scheduling-messages-with-rabbitmq) should be installed.
4. If you are using [warden.dev](https://warden.dev/), please follow the instructions in [warden-dev-configurations.md](warden-dev-configurations.md).

## Installation
```bash
composer require vconnect/module-delayed-amqp-example
bin/magento setup:upgrade
```

## Usage
The module provides a CLI command to Magento 2 that will publish a simple message to RabbitMQ with a delay. Afterward, the message will be received by the module consumer and written into a log file.

1. Make sure that Cronjob is running on the environment. Otherwise, please start the consumer manually via the command:
```bash
bin/magento queue:consumers:start vconnect.delayed.example
```
2. Run the console command to dispatch the message:
```bash
bin/magento delayed-message:send -d 50000 "John Doe"
```
3. Check the log file in `{project directory}/var/log/delayed_message.log`: 
```text
[2024-09-24T15:00:26.454389+00:00] main.INFO: Message for John Doe has been dispatched. []
[2024-09-24T15:01:16.513328+00:00] main.INFO: Hello, John Doe! The message has been received. Delay: 50070 ms. []
```
