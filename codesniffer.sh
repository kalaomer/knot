# Code analyze with code sniffer.
./vendor/bin/phpcs --standard=./code-standards-cs.xml ./src --report=full

./vendor/bin/phpcs --standard=./code-standards-cs.xml ./tests --report=full
