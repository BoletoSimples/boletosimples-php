<?php

require_once 'vendor/autoload.php';

require_once dirname(__FILE__).'/BoletoSimples/Resources/BaseResource.php';
require_once dirname(__FILE__).'/BoletoSimples/Resources/BankBillet.php';
require_once dirname(__FILE__).'/BoletoSimples/Resources/Customer.php';
require_once dirname(__FILE__).'/BoletoSimples/Resources/Transaction.php';
require_once dirname(__FILE__).'/BoletoSimples/BoletoSimples.php';

BoletoSimples::configure();
