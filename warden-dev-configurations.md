# Warden.dev Configuration

Local environment configuration instructions for [Warden.dev](https://warden.dev/) users.

1. Download the [delayed message exchange](https://github.com/rabbitmq/rabbitmq-delayed-message-exchange/) [binary build](https://github.com/rabbitmq/rabbitmq-delayed-message-exchange/releases).
2. Place the binary file under `{project directory}/.warden/rabbitmq/plugins/`
3. Create the file `{project directory}/.warden/rabbitmq/plugins/enabled_plugins` with the content:
```text
[rabbitmq_delayed_message_exchange,rabbitmq_management,rabbitmq_prometheus].
```
4. Create the `{project directory}/.warden/warden-env.yml` file with the following content (please change the binary build filename):
```yml
version: "3.5"
services:
  rabbitmq:
    volumes:
      - ./.warden/rabbitmq/plugins/rabbitmq_delayed_message_exchange-3.12.0.ez:/plugins/rabbitmq_delayed_message_exchange-3.12.0.ez
      - ./.warden/rabbitmq/plugins/enabled_plugins:/etc/rabbitmq/enabled_plugins
```

5. Restart the Warden environment to apply the changes.
```bash
warden env down
warden evn stop
```

6. Run the following command to check if the plugin was installed:
```bash
warden env exec rabbitmq rabbitmq-plugins list | grep "rabbitmq_delayed_message_exchange"
```

7. If everything is correct, the plugin will be listed in the output with the [E*] flag.
```text
[E*] rabbitmq_delayed_message_exchange 3.12.0
```
