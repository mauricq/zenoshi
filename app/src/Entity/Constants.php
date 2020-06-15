<?php

namespace App\Entity;

class Constants
{
    const RESULT_SUCCESS = "SUCCESS";
    const RESULT_ERROR = "ERROR";
    const RESULT_DUPLICATED = "DUPLICATED";
    const RESULT_MESSAGE_DUPLICATED_EMAIL = "Email already registered. ";
    const RESULT_MESSAGE_DUPLICATED_MOBILE = "Mobile already registered. ";
    const RESULT_LABEL_DATA = "Data";
    const RESULT_LABEL_STATUS = "Status";
    const REQUEST_FORMAT_JSON = "json";

    const APP_KEY_HEADER_NAME = "appKey";
    const UNAUTHORIZED_MESSAGE = "Unauthorized, use JWT login or AppKey";
    const AUTHENTICATION_FAILED_MESSAGE = "Unauthorized, use JWT login or AppKey";
}
