# tic-tac-toe.php

Quick implementation of Tic Tac Toe in PHP.

## Install
1. Clone this repository
```
cd /var/www
git clone git@github.com:mimarcel/tic-tac-toe.php.git
```
2. Install with Composer
```
cd /var/www/tic-tac-toe.php/game
composer install
cd /var/www/tic-tac-toe.php/server
composer install
```
3. Test with Composer
```
cd /var/www/tic-tac-toe.php/game
composer test
```

## Run

1. Start server
```
cd /var/www/tic-tac-toe.php/server
php start.php
> Server started
> Waiting for clients...
> Connection open for client 42.
> Receive message {"action": "new"} from client 42.
> Send message {"game":{"id":"42_5b520edc31ae8","status":"wait","grid":"         ","winner":" "}} to client 42.
> Connection open for client 53.
> Receive message {"action": "connect", "id": "42_5b520edc31ae8"} from client 53.
> Send message {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"         ","winner":" "}} to client 42.
> Send message {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"         ","winner":" "}} to client 53.
> Receive message {"action": "mark", "x": "0", "y": "0", "id": "42_5b520edc31ae8"} from client 42.
> Send message {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"X        ","winner":" "}} to client 42.
> Send message {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"X        ","winner":" "}} to client 53.
> Receive message {"action": "mark", "x": "0", "y": "1", "id": "42_5b520edc31ae8"} from client 53.
> Send message {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"X0       ","winner":" "}} to client 42.
> Send message {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"X0       ","winner":" "}} to client 53.
```

2. Start one or more clients
```
telnet localhost 8080
> Trying ::1...
> telnet: connect to address ::1: Connection refused
> Trying 127.0.0.1...
> Connected to localhost.
> Escape character is '^]'.
< {"action": "new"}
> {"game":{"id":"42_5b520edc31ae8","status":"wait","grid":"         ","winner":" "}}
> {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"         ","winner":" "}}
< {"action": "mark", "x": "0", "y": "0", "id": "42_5b520edc31ae8"}
> {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"X        ","winner":" "}}
> {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"X0       ","winner":" "}}
```
```
telnet localhost 8080
> Trying ::1...
> Telnet: connect to address ::1: Connection refused
> Trying 127.0.0.1...
> Connected to localhost.
> Escape character is '^]'.
< {"action": "connect", "id": "42_5b520edc31ae8"}
> {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"         ","winner":" "}}
> {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"X        ","winner":" "}}
< {"action": "mark", "x": "0", "y": "1", "id": "42_5b520edc31ae8"}
> {"game":{"id":"42_5b520edc31ae8","status":"in progress","grid":"X0       ","winner":" "}}
```
