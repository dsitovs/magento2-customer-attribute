# Magento 2 - test task

Frontend:
1) Add a new link to menu in the customer account
2) When opening the link, show a form with one field "Status" and button "Save"
3) when a customer fills in the status and presses the save button, the status gets saved
4) The status must be displayed in the top right corner. Right after the welcome message.
5) It must work correctly with all the caches enabled

Backend:
1) The saved status must be displayed in admin in customer edit page.
2) Admin can change the status

## Table of contents
* [Prerequisites](#prerequisites)
* [Installation](#installation)
    * [Via composer](#via-composer)
    * [Manually](#manually)

## Prerequisites
* Magento 2.4.6
* PHP 8.0+

## Installation

#### Via composer
Run these commands in your root magento directory
```
composer config repositories.dsitovs/magento2-customer-attribute git git@github.com:dsitovs/magento2-customer-attribute.git
composer require dsitovs/magento2-customer-attribute
bin/magento setup:upgrade
```

#### Manually
* Create `TestExample` directory in `app/code`
    * `cd app/code`
    * `mkdir TestExample`
    * `cd TestExample`
    * `mkdir CustomerAttribute`
* Extract this repo contents inside `CustomerAttribute` directory

