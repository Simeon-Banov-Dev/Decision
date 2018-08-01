<?php
return [
    "DecisionAddonMethod" => [
        "getWebRequest" => [
            "JavaDoc" => [
                "Comment" => "using lazy initialization of class to ensure initializing it only when needed",
                "return" => "\\Decision\\Web\\Request",
                "author" => "Simeon Banov <svbmony@gmail.com>"
            ],
            "modifier" => "public",
            "returnbyreference" => true,
            "body" => [
                "\$modules = decision()->__getModules();",
                "if(!isset(\$modules[\"Decision Web Request\"])) {",
                "\t\$modules[\"Decision Web Request\"] = \\Decision\\Web\\Request::getInstance();",
                "}",
                "return \$modules[\"Decision Web Request\"];"
            ]
        ],
        "getWebRouter" => [
            "JavaDoc" => [
                "Comment" => "using lazy initialization of class to ensure initializing it only when needed",
                "return" => "\\Decision\\Web\\Router\\Router",
                "author" => "Simeon Banov <svbmony@gmail.com>"
            ],
            "modifier" => "public",
            "returnbyreference" => true,
            "body" => [
                "\$modules = decision()->__getModules();",
                "if(!isset(\$modules[\"Decision Web Router Router\"])) {",
                "\t\$modules[\"Decision Web Router Router\"] = \\Decision\\Web\\Router\\Router::getInstance();",
                "}",
                "return \$modules[\"Decision Web Router Router\"];"
            ]
        ]
    ]
];