<?php

namespace App\Entity;

class Constants
{
    const RESULT_SUCCESS = "SUCCESS";
    const RESULT_ERROR = "ERROR";
    const RESULT_DUPLICATED = "DUPLICATED";
    const RESULT_DUPLICATED_CODE = 002;
    const RESULT_MESSAGE_DUPLICATED_EMAIL = "Email already registered. ";
    const RESULT_MESSAGE_DUPLICATED_USERNAME = "Username already registered. ";
    const RESULT_MESSAGE_DUPLICATED_MOBILE = "Mobile already registered. ";
    const RESULT_MESSAGE_DUPLICATED = " already registered. ";
    const RESULT_LABEL_DATA = "Data";
    const RESULT_LABEL_STATUS = "Status";
    const REQUEST_FORMAT_JSON = "json";
    const RESULT_FILE_UPLOADED = "File uploaded";

    const APP_KEY_HEADER_NAME = "appKey";
    const UNAUTHORIZED_MESSAGE = "{\"Unauthorized, use JWT login or AppKey\"}";
    const AUTHENTICATION_FAILED_MESSAGE = "{\"Unauthorized, use JWT login or AppKey\"}";
    const AUTHENTICATION_WRONG_CREDENTIALS = "Credentials are wrong";

    const LOGIN_LABEL_USERNAME = "username";
    const LOGIN_LABEL_PASSWORD = "password";
    const CATALOG_LABEL = "CATALOG";

    const PREPARED_DATA_JSON_KEY_INPUT = "0";
    const PREPARED_DATA_ID_FIELD_DB = "0";
    const PREPARED_DATA_ID_FIELD = "1";
    const PREPARED_DATA_FK_ENTITY = "2";
    const PREPARED_DATA_FK_IDENTITY = "3";
    const PREPARED_DATA_FK_ID_ENTITY = "4";
    const PREPARED_DATA_PATH_ENTITY = "App\Entity\\";
    const UNIQUE_ID_GROUP_GENERATION = 5;
    const FILTER_SEPARATOR = ":";
    const FILTER_POSITION_FILTER = 0;
    const FILTER_POSITION_VALUE = 1;

}
