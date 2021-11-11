c<?php

    /** @var \Illuminate\Database\Eloquent\Factory $factory */

    use App\Trek;
    use Faker\Generator as Faker;

    $directions = [
        '{
        "geocoded_waypoints": [
            {
                "geocoder_status": "OK",
                "place_id": "ChIJPac_0y-GOxAR-DC8y45ySa0",
                "types": [
                    "establishment",
                    "premise"
                ]
            },
            {
                "geocoder_status": "OK",
                "place_id": "ChIJo-9Vvh6GOxAR4ouMreNoJjM",
                "types": [
                    "neighborhood",
                    "political"
                ]
            }
        ],
        "routes": [
            {
                "bounds": {
                    "northeast": {
                        "lat": 6.4665526,
                        "lng": 3.2563806
                    },
                    "southwest": {
                        "lat": 6.4482876,
                        "lng": 3.2487351
                    }
                },
                "copyrights": "Map data ©2021",
                "legs": [
                    {
                        "distance": {
                            "text": "3.1 km",
                            "value": 3087
                        },
                        "duration": {
                            "text": "40 mins",
                            "value": 2374
                        },
                        "end_address": "Trade Fair Complex, Lagos, Nigeria",
                        "end_location": {
                            "lat": 6.4665526,
                            "lng": 3.2533717
                        },
                        "start_address": "Unipetrol Rd, Satellite Town, Lagos, Nigeria",
                        "start_location": {
                            "lat": 6.4482876,
                            "lng": 3.2487351
                        },
                        "steps": [
                            {
                                "distance": {
                                    "text": "0.4 km",
                                    "value": 435
                                },
                                "duration": {
                                    "text": "5 mins",
                                    "value": 321
                                },
                                "end_location": {
                                    "lat": 6.4487388,
                                    "lng": 3.2526444
                                },
                                "html_instructions": "Head <b>east</b> on <b>Unipetrol Rd</b><div style=\"font-size:0.9em\">Pass by Jimmy Travels &amp; Tours Limited (on the left in 140&nbsp;m)</div>",
                                "polyline": {
                                    "points": "yljf@soyRCg@Ci@?CCc@G_AGiAGoAIkAEi@Ea@Ck@Cc@OqCEw@AE"
                                },
                                "start_location": {
                                    "lat": 6.4482876,
                                    "lng": 3.2487351
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "0.1 km",
                                    "value": 134
                                },
                                "duration": {
                                    "text": "2 mins",
                                    "value": 100
                                },
                                "end_location": {
                                    "lat": 6.4499401,
                                    "lng": 3.2525093
                                },
                                "html_instructions": "Turn <b>left</b> at Omot Aluminium Enterprises onto <b>Western Ave</b>",
                                "maneuver": "turn-left",
                                "polyline": {
                                    "points": "sojf@_hzRyDPk@DI@"
                                },
                                "start_location": {
                                    "lat": 6.4487388,
                                    "lng": 3.2526444
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "0.3 km",
                                    "value": 276
                                },
                                "duration": {
                                    "text": "3 mins",
                                    "value": 203
                                },
                                "end_location": {
                                    "lat": 6.4524061,
                                    "lng": 3.2522579
                                },
                                "html_instructions": "Continue onto <b>Mobil Rd</b><div style=\"font-size:0.9em\">Pass by St May\'s Health Shop (on the left in 51&nbsp;m)</div>",
                                "polyline": {
                                    "points": "cwjf@egzRc@BU@qAHm@DgBHc@BaBFY@a@BI?"
                                },
                                "start_location": {
                                    "lat": 6.4499401,
                                    "lng": 3.2525093
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "0.2 km",
                                    "value": 233
                                },
                                "duration": {
                                    "text": "3 mins",
                                    "value": 170
                                },
                                "end_location": {
                                    "lat": 6.454491099999999,
                                    "lng": 3.2520348
                                },
                                "html_instructions": "At Emmy 70\" Barbing Salon, continue onto <b>Mustapha Ojora St</b><div style=\"font-size:0.9em\">Pass by Lac Vet Stores (on the right in 86&nbsp;m)</div>",
                                "polyline": {
                                    "points": "qfkf@sezRcCN}@F}ET"
                                },
                                "start_location": {
                                    "lat": 6.4524061,
                                    "lng": 3.2522579
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "7 m",
                                    "value": 7
                                },
                                "duration": {
                                    "text": "1 min",
                                    "value": 6
                                },
                                "end_location": {
                                    "lat": 6.4544837,
                                    "lng": 3.2519754
                                },
                                "html_instructions": "Turn <b>left</b> at Sunny Best Ventures onto <b>Old Ojo Rd</b>",
                                "maneuver": "turn-left",
                                "polyline": {
                                    "points": "qskf@edzR@H"
                                },
                                "start_location": {
                                    "lat": 6.454491099999999,
                                    "lng": 3.2520348
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "65 m",
                                    "value": 65
                                },
                                "duration": {
                                    "text": "1 min",
                                    "value": 51
                                },
                                "end_location": {
                                    "lat": 6.4550693,
                                    "lng": 3.2519237
                                },
                                "html_instructions": "Turn <b>right</b> at Glo",
                                "maneuver": "turn-right",
                                "polyline": {
                                    "points": "oskf@{czRuBJ"
                                },
                                "start_location": {
                                    "lat": 6.4544837,
                                    "lng": 3.2519754
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "0.5 km",
                                    "value": 467
                                },
                                "duration": {
                                    "text": "6 mins",
                                    "value": 339
                                },
                                "end_location": {
                                    "lat": 6.4555539,
                                    "lng": 3.2561172
                                },
                                "html_instructions": "Turn <b>right</b><div style=\"font-size:0.9em\">Pass by Ile- Epo (on the right in 170&nbsp;m)</div>",
                                "maneuver": "turn-right",
                                "polyline": {
                                    "points": "ewkf@oczRIqAQwBEeAEs@?COuCCYKkBEy@Ey@C]C[C_@?U"
                                },
                                "start_location": {
                                    "lat": 6.4550693,
                                    "lng": 3.2519237
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "31 m",
                                    "value": 31
                                },
                                "duration": {
                                    "text": "1 min",
                                    "value": 39
                                },
                                "end_location": {
                                    "lat": 6.4554944,
                                    "lng": 3.2563806
                                },
                                "html_instructions": "Slight <b>right</b> at Abule Ado<div style=\"font-size:0.9em\">Take the stairs</div>",
                                "maneuver": "turn-slight-right",
                                "polyline": {
                                    "points": "ezkf@w}zRBABG@I@_@"
                                },
                                "start_location": {
                                    "lat": 6.4555539,
                                    "lng": 3.2561172
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "92 m",
                                    "value": 92
                                },
                                "duration": {
                                    "text": "2 mins",
                                    "value": 125
                                },
                                "end_location": {
                                    "lat": 6.4563153,
                                    "lng": 3.2562739
                                },
                                "html_instructions": "Take the pedestrian overpass",
                                "polyline": {
                                    "points": "yykf@k_{Rc@Bc@Dc@Bc@BM@G@"
                                },
                                "start_location": {
                                    "lat": 6.4554944,
                                    "lng": 3.2563806
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "48 m",
                                    "value": 48
                                },
                                "duration": {
                                    "text": "1 min",
                                    "value": 52
                                },
                                "end_location": {
                                    "lat": 6.456150200000001,
                                    "lng": 3.255914
                                },
                                "html_instructions": "Turn <b>left</b><div style=\"font-size:0.9em\">Take the stairs</div>",
                                "maneuver": "turn-left",
                                "polyline": {
                                    "points": "__lf@u~zRFt@HHFBFB"
                                },
                                "start_location": {
                                    "lat": 6.4563153,
                                    "lng": 3.2562739
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "42 m",
                                    "value": 42
                                },
                                "duration": {
                                    "text": "1 min",
                                    "value": 31
                                },
                                "end_location": {
                                    "lat": 6.4560977,
                                    "lng": 3.25554
                                },
                                "html_instructions": "Turn <b>right</b> at Jumatex Investment",
                                "maneuver": "turn-right",
                                "polyline": {
                                    "points": "}}kf@m|zRHhA"
                                },
                                "start_location": {
                                    "lat": 6.456150200000001,
                                    "lng": 3.255914
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "0.4 km",
                                    "value": 362
                                },
                                "duration": {
                                    "text": "5 mins",
                                    "value": 271
                                },
                                "end_location": {
                                    "lat": 6.4592981,
                                    "lng": 3.2552059
                                },
                                "html_instructions": "Turn <b>right</b> at Jumatex Investment<div style=\"font-size:0.9em\">Pass by First Chrisway Gas Plant (on the right in 350&nbsp;m)</div>",
                                "maneuver": "turn-right",
                                "polyline": {
                                    "points": "s}kf@czzRe@ZG?a@@aCLeCLE?W@mBJ_@@c@?G?oAG"
                                },
                                "start_location": {
                                    "lat": 6.4560977,
                                    "lng": 3.25554
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "0.8 km",
                                    "value": 824
                                },
                                "duration": {
                                    "text": "10 mins",
                                    "value": 604
                                },
                                "end_location": {
                                    "lat": 6.466524199999999,
                                    "lng": 3.2539913
                                },
                                "html_instructions": "Slight <b>left</b> at Kobis Comm Ltd onto <b>Otunba Gani Adams Rd</b><div style=\"font-size:0.9em\">Pass by Austine Best Electronics &amp; Electrical (on the right in 120&nbsp;m)</div>",
                                "maneuver": "turn-slight-left",
                                "polyline": {
                                    "points": "sqlf@axzR}@RaANm@Hc@D]BC?A?Y@G@w@?wABcBD}AFa@@mADwADwAN_@DQB]BiAHy@DcBH_@B{@JOD]FGBOFQJMHMHABOP"
                                },
                                "start_location": {
                                    "lat": 6.4592981,
                                    "lng": 3.2552059
                                },
                                "travel_mode": "WALKING"
                            },
                            {
                                "distance": {
                                    "text": "71 m",
                                    "value": 71
                                },
                                "duration": {
                                    "text": "1 min",
                                    "value": 62
                                },
                                "end_location": {
                                    "lat": 6.4665526,
                                    "lng": 3.2533717
                                },
                                "html_instructions": "Turn <b>left</b> at Korodo Block Industry<div style=\"font-size:0.9em\">Pass by Vidapet Global Resources Limited (on the right in 42&nbsp;m)</div><div style=\"font-size:0.9em\">Destination will be on the right</div>",
                                "maneuver": "turn-left",
                                "polyline": {
                                    "points": "w~mf@mpzR@JAr@@`@EBAB?D?F?B"
                                },
                                "start_location": {
                                    "lat": 6.466524199999999,
                                    "lng": 3.2539913
                                },
                                "travel_mode": "WALKING"
                            }
                        ],
                        "traffic_speed_entry": [],
                        "via_waypoint": []
                    }
                ],
                "overview_polyline": {
                    "points": "yljf@soyRKyBa@eHS{CUiEAEyDPu@Fy@DkG\\\\gDLaEV}ET@HuBJIqAW}DYgF[}FG{@?UBADQ@_@c@BgAHq@DG@Ft@PLFBHhAe@ZG?cDNkCLeCLcA@wAG_Cb@sBR{AB{HReDJwBTsDVcCLkAPe@Ja@R[RQT?~@@`@EBAH?J"
                },
                "summary": "Otunba Gani Adams Rd",
                "warnings": [
                    "Walking directions are in beta. Use caution – This route may be missing sidewalks or pedestrian paths."
                ],
                "waypoint_order": []
            }
        ],
        "status": "OK"
    }',
        '{
        "geocoded_waypoints": [
            {
                "geocoder_status": "OK",
                "place_id": "ChIJPac_0y-GOxAR-DC8y45ySa0",
                "types": [
                    "establishment",
                    "premise"
                ]
            },
            {
                "geocoder_status": "OK",
                "place_id": "ChIJKcTl0yCGOxARWI_R41rlpsQ",
                "types": [
                    "establishment",
                    "point_of_interest",
                    "transit_station"
                ]
            }
        ],
        "routes": [
            {
                "bounds": {
                    "northeast": {
                        "lat": 6.4584252,
                        "lng": 3.2721445
                    },
                    "southwest": {
                        "lat": 6.4482876,
                        "lng": 3.2487351
                    }
                },
                "copyrights": "Map data ©2021",
                "legs": [
                    {
                        "distance": {
                            "text": "5.3 km",
                            "value": 5317
                        },
                        "duration": {
                            "text": "15 mins",
                            "value": 895
                        },
                        "duration_in_traffic": {
                            "text": "13 mins",
                            "value": 759
                        },
                        "end_address": "Abule Ado Bus Stop, Satellite Town, Lagos, Nigeria",
                        "end_location": {
                            "lat": 6.4561927,
                            "lng": 3.2562291
                        },
                        "start_address": "Unipetrol Rd, Satellite Town, Lagos, Nigeria",
                        "start_location": {
                            "lat": 6.4482876,
                            "lng": 3.2487351
                        },
                        "steps": [
                            {
                                "distance": {
                                    "text": "0.4 km",
                                    "value": 435
                                },
                                "duration": {
                                    "text": "2 mins",
                                    "value": 118
                                },
                                "end_location": {
                                    "lat": 6.4487388,
                                    "lng": 3.2526444
                                },
                                "html_instructions": "Head <b>east</b> on <b>Unipetrol Rd</b><div style=\"font-size:0.9em\">Pass by Jimmy Travels &amp; Tours Limited (on the left)</div>",
                                "polyline": {
                                    "points": "yljf@soyRCg@Ci@?CCc@G_AGiAGoAIkAEi@Ea@Ck@Cc@OqCEw@AE"
                                },
                                "start_location": {
                                    "lat": 6.4482876,
                                    "lng": 3.2487351
                                },
                                "travel_mode": "DRIVING"
                            },
                            {
                                "distance": {
                                    "text": "0.1 km",
                                    "value": 129
                                },
                                "duration": {
                                    "text": "1 min",
                                    "value": 46
                                },
                                "end_location": {
                                    "lat": 6.449890799999999,
                                    "lng": 3.2525154
                                },
                                "html_instructions": "Turn <b>left</b> at Omot Aluminium Enterprises onto <b>Western Ave</b>",
                                "maneuver": "turn-left",
                                "polyline": {
                                    "points": "sojf@_hzRyDPk@D"
                                },
                                "start_location": {
                                    "lat": 6.4487388,
                                    "lng": 3.2526444
                                },
                                "travel_mode": "DRIVING"
                            },
                            {
                                "distance": {
                                    "text": "0.3 km",
                                    "value": 276
                                },
                                "duration": {
                                    "text": "1 min",
                                    "value": 56
                                },
                                "end_location": {
                                    "lat": 6.452363699999999,
                                    "lng": 3.252261
                                },
                                "html_instructions": "At MoMo Agent, continue onto <b>Mobil Rd</b><div style=\"font-size:0.9em\">Pass by St May\'s Health Shop (on the left)</div>",
                                "polyline": {
                                    "points": "yvjf@ggzRI@c@BU@qAHm@DgBHc@BaBFY@a@B"
                                },
                                "start_location": {
                                    "lat": 6.449890799999999,
                                    "lng": 3.2525154
                                },
                                "travel_mode": "DRIVING"
                            },
                            {
                                "distance": {
                                    "text": "2.5 km",
                                    "value": 2529
                                },
                                "duration": {
                                    "text": "7 mins",
                                    "value": 422
                                },
                                "end_location": {
                                    "lat": 6.4574191,
                                    "lng": 3.271859
                                },
                                "html_instructions": "At Adejare Stores, continue onto <b>Mustapha Ojora St</b><div style=\"font-size:0.9em\">Pass by Lac Vet Stores (on the right)</div>",
                                "polyline": {
                                    "points": "gfkf@sezRI?cCN}@F}ET@HuBJIqAQwBEeAEs@?COuCCYKkBEy@Ey@C]C[C_@?UAMAU?MCUC[?GEc@Eu@?AKyACQK}ACo@Ck@QgC?EC]Cc@Ec@K{AAOQoCAQK}AOkCCk@GaB?CMiBKkBAQCe@IwACc@Co@CWCc@QoCYcEAMAUASGy@SkBGy@[eFEo@CWCc@Cc@IqACy@Ag@AQ?m@?S"
                                },
                                "start_location": {
                                    "lat": 6.452363699999999,
                                    "lng": 3.252261
                                },
                                "travel_mode": "DRIVING"
                            },
                            {
                                "distance": {
                                    "text": "0.2 km",
                                    "value": 154
                                },
                                "duration": {
                                    "text": "1 min",
                                    "value": 59
                                },
                                "end_location": {
                                    "lat": 6.4582054,
                                    "lng": 3.2720021
                                },
                                "html_instructions": "At the roundabout, take the <b>3rd</b> exit<div style=\"font-size:0.9em\">Pass by GROWTH PRINT INTEGRATED SERVICES LIMITED (on the left)</div>",
                                "maneuver": "roundabout-right",
                                "polyline": {
                                    "points": "{elf@c`~R@@@?@?@?@?@?@?@?@?@A@?@?@A@??A@?@A@A?A@??A@A?A@A?A?A?A?A?A?A?A?A?AAA?AAA?AAA?AA??AA??AA?AAA?AAA?A?A?AAA?A?A?A@A?A?A?A@C@A@A?A@?@A@c@Bc@Bc@Bc@B"
                                },
                                "start_location": {
                                    "lat": 6.4574191,
                                    "lng": 3.271859
                                },
                                "travel_mode": "DRIVING"
                            },
                            {
                                "distance": {
                                    "text": "1.8 km",
                                    "value": 1794
                                },
                                "duration": {
                                    "text": "3 mins",
                                    "value": 194
                                },
                                "end_location": {
                                    "lat": 6.4561927,
                                    "lng": 3.2562291
                                },
                                "html_instructions": "At the roundabout, take the <b>2nd</b> exit<div style=\"font-size:0.9em\">Pass by Access Closa Agent (on the right)</div><div style=\"font-size:0.9em\">Destination will be on the right</div>",
                                "maneuver": "roundabout-right",
                                "polyline": {
                                    "points": "yjlf@_a~R?AA?AAAAA?A?AAA?A?A?A?A?A?A@A?A??@A?A@A@A@A@?@A@?@?@?@A??@?@?@@??@?@?@?@@@?@@??@@@@@@??@@?@@@?@?@@@?@?JJBDDRLj@FZFb@Df@Ff@@LD`@BZ@FB`@@J@TDt@Ft@B\\\\BXLvBFzA?@B|@?DDdA@@FlAHfA@PHdAHbAD`@?@JdBHbADbADv@Bn@B`@?NN`CBXPdB@RPvBF`ADf@@ZL`CDt@@TB`@?FBXHdA@@RfD?@DbAB`@HdAB^Dv@JtAHfA@L"
                                },
                                "start_location": {
                                    "lat": 6.4582054,
                                    "lng": 3.2720021
                                },
                                "travel_mode": "DRIVING"
                            }
                        ],
                        "traffic_speed_entry": [],
                        "via_waypoint": []
                    }
                ],
                "overview_polyline": {
                    "points": "yljf@soyRKyBa@eHS{CUiEAEyDPu@Fy@DkG\\\\gDLaEV}ET@HuBJIqAW}DYgFe@}IUyD_@yFYwEgA_QY{F[{F_AgOImA[eDi@qISwEA_A@QF?F?LGFM?MGMKGM?ODCDoCNKGI?IBGFCH@HJNHBPPb@~BT~BJpAR~CXnFJjC\\\\lFZlEXnFVlEl@rHd@tIv@|L\\\\bF"
                },
                "summary": "Unipetrol Rd",
                "warnings": [],
                "waypoint_order": []
            }
        ],
        "status": "OK"
    }'

    ];

    $factory->define(Trek::class, function (Faker $faker) use ($directions) {
        return [
            'name' => $faker->sentence,
            'start_address_id' => rand(1, 20),
            'end_address_id' => rand(1, 20),
            'direction' => $directions[rand(0, 1)],
            'starting_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            'duration' => random_int(30, 3000),
            'user_id' => rand(1, 5),
            'description'=> $faker->sentence,
        ];
    });



