.PHONY:dev deploy
ssh=ssh ubuntu@vps-ded539c2.vps.ovh.net
dir=/var/www/survey
p=/var/www/survey/public
js=/var/www/survey/public/js

dev:
	tmux \
		new-session "php artisan serve" \;\
		split-window -h "npm run hot" \;\
		split-window -h "laravel-echo-server start" \;\

deploy:
	git archive master -o deploy.zip
	rsync -a --progress deploy.zip -e '$(ssh)' :~/
	$(ssh) "unzip -o ./deploy.zip -d $(dir)/"
	$(ssh) "cd $(dir); composer install --no-dev --optimize-autoloader"
	$(ssh) "cd $(dir); php artisan migrate"
	$(ssh) "cd $(dir); npm i"
	# $(ssh) "cd $(js); rm *.js"
	$(ssh) "cd $(dir); npm run production"
	$(ssh) "rm deploy.zip"
	rm deploy.zip

