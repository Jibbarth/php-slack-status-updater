# :technologist: Slack Status Updater

It's boring to manually click on slack, find how update emoji on status, or even add a custom message.

As you are lazy, you want a command line tool that can do this for you.

That's why I created this tool: 

![Demo](https://user-images.githubusercontent.com/3168281/119533907-9e0f4400-bd86-11eb-9f81-59a5422bf486.gif)

Let's install it and explore how use it...

### Installation

Make sure you have PHP (>=8.0) and Composer installed. Then

```bash
composer global require barth/php-slack-status-updater
```

> You have to export in your path the global composer binary path

Or you can find the latest phar in the [release tab](https://github.com/Jibbarth/php-slack-status-updater/releases)

### Configuration

You have to create an app on slack with following scopes: 

* `users:write`
* `users.profile:write`

Then, install it into your slack workspace, and retrieve a token for your user.

Save your token by launching the following command: 

```bash
slack-status-updater auth
```

### How To Use

To manually change your status message or emoji, launch:

```bash
slack-status-updater update-status --message="Hello teams" --emoji=wave
```
> Note that message and emoji option are optionnal. 

There is two dedicated script for the wakeup and shutdown. 

```bash
# Mark you as active on slack
slack-status-updater wakeup [--message="Hello teams" --emoji=wave]

# Mark you as absent on slack
slack-status-updater shutdown [--message="See you later" --emoji=zzz]
```

### Auto scripts

If you are really lazy, you can configure startup script and shutdown script to handle this for you.

Launch the following command:

```bash
slack-status-updater generate-script
```
And answer to the questions. If you leave blank for emoji, the script will use a random emoji :sparkles:  

> :warning: Currently, script generation only work for Linux. It register an autostart application in `~/.config/autostart/`. 
> Need [freedesktop](https://specifications.freedesktop.org/desktop-entry-spec/latest/)

### Contribute ?

You know how to generate auto script on windows on MacOs ? 
You want improve the commands output ? 
Add an awesome feature ? 

You are more than welcome :hugs:
