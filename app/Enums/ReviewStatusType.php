<?php
/**
 * Created by PhpStorm.
 * User: lanebandli
 * Date: 8/24/17
 * Time: 9:57 AM
 */
namespace App\Enums;

abstract class ReviewStatusType {
    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';
    const UNSEEN = 'unseen';
    const OVERRIDDEN = 'overridden';
}