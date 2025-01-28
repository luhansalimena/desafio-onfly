<?php

namespace App;

enum OrderStatus: string
{
    case REQUESTED = 'requested';
    case APPROVED = 'approved';
    case CANCELLED = 'cancelled';
}
