<?php

Jenu::command('help', function(){
    $apps = [];
    $others = [];

    foreach (Jenu::$commands as $command) {
        $parts = explode(":", $command['type']);
        
        if (count($parts) === 2) {
            list($type, $group) = $parts;

            // Agrupar comandos por tipo y grupo
            if (!isset($apps[$type][$group])) {
                $apps[$type][$group] = [];
            }

            $apps[$type][$group][] = [
                'command' => $command['command'],
                'message' => $command['help']
            ];
        } else {
            // Comandos que no siguen el formato type:group
            $others[] = [
                'command' => $command['command'],
                'message' => $command['help']
            ];
        }
    }

    // Imprimir comandos en el formato deseado

    foreach ($apps as $type => $groups) {
        Jenu::warn("\n$type:", false);
        foreach ($groups as $group => $commands) {
            foreach ($commands as $cmd) {
                printf("\033[32m%-30s %-15s %s\033[0m\n", $cmd['command'], "(".$group.")", $cmd['message']);
            }
        }
    }

    // Imprimir comandos "Otros"
    if(!empty($others)){
        Jenu::warn("\nOtros:", false);
        foreach ($others as $other) {
            printf("\033[32m%-30s %-15s %s\033[0m\n", $other['command'], "", $other['message']);
        }
        print("\n");
    }


}, "Help command", 'Sao:Help');
