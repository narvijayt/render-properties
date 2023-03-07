<?php

namespace App\Enums;

abstract class MatchActionType {
	const INITIAL = 'initial';
	const ACCEPT = 'accept';
	const REJECT = 'reject';
	const REMOVE = 'remove';
	const RENEW = 'renew';
}
