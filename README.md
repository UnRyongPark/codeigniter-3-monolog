# codeigniter-3-monolog

# English
A core extension library for easy using the [Monolog](https://github.com/Seldaek/monolog) in [Codeigniter](https://codeigniter.com/)

Please refer to [Link](https://codeigniter.com/user_guide/general/core_classes.html) for reference to Core Class Extending.

How To Install

1. install Codeigniter 3.x
2. install monolog by composer
    `composer require monolog/monolog`
3. place `application/core/MY_Log.php` into your `application/core/` folder 
4. Use the same as codeigniter's log_message! Enjoy!

※ If you want to add more handlers or contents, proceed as follows.
※ For a list of handlers supported by Monolog, please refer to [link](https://github.com/Seldaek/monolog/blob/master/doc/02-handlers-formatters-processors.md).
1. Open `MY_Log.php` file
2. In the `$target_handlers` array, specify the name of the method to invoke to create the desired handler.
3. Create a method called 'Name(in `$target_handlers`) + "Handler"' and put the contents.
(Inside MY_Log.php you already have examples for Raven - `ravenHandler()`, files - `fileHandler()`, and Slack Webhook - `slackWebhookHandler()`.)
4. Use!

* * *

# 한국어(korean)
[Codeigniter](https://codeigniter.com/) 3.x 버전에서 쉽게 [Monolog](https://github.com/Seldaek/monolog)를 사용할 수 있게 만든 Core Extending Class입니다.

Core Class Extending과 관련한 내용은 [링크](http://www.ciboard.co.kr/user_guide/kr/general/core_classes.html)를 참고하시기 바랍니다.

설치방법

1. Codeigniter 3.x버전을 설치합니다.
2. composer를 사용해서 monolog를 설치해줍니다.
    `composer require monolog/monolog`
3. `/application/core/MY_Log.php` 파일을 당신의 `/application/core/`폴더에 복사해주세요.
4. 기존에 사용하시던 codeigniter의 log_message와 동일하게 사용하시면 됩니다.

※ 만약 더 많은 핸들러나 내용을 추가하려면 다음과 같은 방법으로 진행하시면 됩니다.
※ Monolog가 지원하는 핸들러 목록은 [링크](https://github.com/Seldaek/monolog/blob/master/doc/02-handlers-formatters-processors.md)를 참고하시기 바랍니다.
1. `MY_Log.php` 파일을 열어주세요
2. `$target_handlers` 배열에 원하는 핸들러를 만들게 호출할 메서드의 이름을 정해주세요.
3. 입력한 "이름+Handler"라는 메서드를 생성하고 내용을 넣어주세요.
(MY_Log.php 파일 안에 이미 Raven - `ravenHandler()`, 파일 - `fileHandler()`, Slack Webhook - `slackWebhookHandler()`용 예제가 준비되어 있습니다.)
4. 이용합니다!