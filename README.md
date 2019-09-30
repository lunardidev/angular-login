# angular-login 1.3
User Authentication (signup, login, logout) using angularJS, php and mysql using generator-angular 0.9.8.

Angular 1.3: https://devdocs.io/angularjs~1.3

This is a simple user authentication built with angularJS 1.3.

## Automation with Grunt
Grunt is a JavaScript task runner (Automation), save yourself from repetitive tasks.
Install project dependencies with npm install.

npm install grunt --save-dev

## How to run this app?
  - Run Grunt with: grunt.
  - Run Grunt with PHP: grunt php

You'll need to put the files on a server to run it.
So you can upload the "dist" folder to your server to run it. Or you can build a server locally.
Then how to build a server locally?

You can build a locally server using WAMP or MAMP (if you uses PHP). And here we'll build a local server with NodeJS

Preparation: You'll need to install Node.js (NPM comes along with it) and node-static (an NPM package)

## How to distribution this app?
Run Grunt with: grunt build

## How to test this app?
Run Grunt with: grunt test

## How to Use It? (Sass Version, The Default)
In order to do development with it, you'll need have the following tools installed:

Node.js (NPM comes along with it)
Yeoman (if you are using npm 1.2.10 or above, this will also automatically install Bower, Grunt) for modern workflow.
Ruby, Sass and Compass for Sass CSS.

## Introduction to the important files:

- ".bowerrc": is used for config Twitter Bower

- "bower.json": is the JSON file of Twitter Bower

- "Gruntfile.js": is the configure file of Grunt. It is used to configure or define tasks and load Grunt plugins.

- "package.json": is the JSON file of Grunt. This file is used by npm to store metadata for projects published as npm modules. 
You will list grunt and the Grunt plugins your project needs as devDependencies in this file.

- "test/phpnit/composer.json": is used for config phpUnit

- "test/karma.conf.js": is used for config karma for test javascript (tasks).





