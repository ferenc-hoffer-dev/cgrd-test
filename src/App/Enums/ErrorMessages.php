<?php

namespace App\Enums;

enum ErrorMessages: string
{
    case NewsNotFound = 'The selected news item was not found.';
    case InvalidData = 'Invalid data submitted.';
    case SaveFailed = 'Failed to save the news item. Please try again.';
    case DeleteFailed = 'Failed to delete the news item.';
    case UnauthorizedAccess = 'You are not authorized to perform this action.';
    case LoginFailed = 'Invalid username or password.';
    case GeneralError = 'An unexpected error occurred.';
}
