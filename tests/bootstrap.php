<?php

error_reporting(E_ALL);

\VCR\VCR::configure() ->setMode('once');
\VCR\VCR::turnOn();