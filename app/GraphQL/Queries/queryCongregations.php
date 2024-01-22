<?php

$query_get_congregations =  '
                                query listFaithHubSpotCongregations {
                                    listFaithHubSpotCongregations {
                                        items {
                                            id
                                            code
                                            nameEnglish
                                            nameNative
                                        }
                                    }
                                }
                            ';