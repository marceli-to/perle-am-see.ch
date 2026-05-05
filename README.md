# perle-am-see/perle-am-see.ch

## Urls
- https://<project>-gulp-<user>.nexocom.dev/
- https://<project>-<user>.nexocom.dev/



## Getting Started

Download JetBrains Gateway
https://www.jetbrains.com/de-de/remote-development/gateway/

Setup Remote Connection using SSH
Host: remote.nexocom.dev
User: <username>
Your SSH-Key

Once connected, checkout repository. Download links:
SSH clone URL: ssh://git@git.jetbrains.space/webk/perle-am-see/perle-am-see.ch.git
HTTPS clone URL: https://git.jetbrains.space/webk/perle-am-see/perle-am-see.ch.git

1) Adjust permissions on host system (required depending on host OS):
```
sudo chmod 777 -R ./app
```
2) Open terminal to web-container
3) Run ```composer install``` inside web-container (**not** update!)
4) Get your copy of a .env file and store within the /app folder


## Prerequisites

JetBrains Gateway
