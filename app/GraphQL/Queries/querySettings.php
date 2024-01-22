<?php

$query_get_settings =   '
                            query getSettings($code: String!) {
                                getSettings(code: $code) {
                                code
                                config
                                }
                            }
                        ';