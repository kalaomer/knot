# Code analyze with code sniffer.
./vendor/bin/phpcs --standard=./vendor/pragmarx/laravelcs/Standards/Laravel/ ./src --report=full

./vendor/bin/phpcs --standard=./vendor/pragmarx/laravelcs/Standards/Laravel/ ./tests --report=full
