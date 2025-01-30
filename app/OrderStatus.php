<?php

namespace App;

enum OrderStatus: string
{
    case REQUESTED = 'REQUESTED';
    case APPROVED = 'APPROVED';
    case CANCELLED = 'CANCELLED';
}
