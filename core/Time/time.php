<?php
class Time{


    /**
     * Calculate age from birthdate.
     *
     * @param string $birthdate The birthdate in "YYYY-MM-DD" format.
     *
     * @return array The calculated age.
     */
    public function calculateAgeFromBirthdate(string $birthdate) {
        $birthdate = new DateTime($birthdate);
        $now = new DateTime(date("Y-m-d"));
        $diff = $now->diff($birthdate);
        return [
            'years' => $diff->y,
            'months' => $diff->m,
            'days' => $diff->d,
        ];
    }

    public function builtMessageAge(array $date){
        $messageAge = "";
        if ($date['years'] > 0) {
            $messageAge .= $date['years'] . ' año' . ($date['years'] > 1 ? 's' : '') . ', ';
        }
        if ($date['months'] > 0) {
            $messageAge .= $date['months'] . ' mes' . ($date['months'] > 1 ? 'es' : '') . ', ';
        }
        if ($date['days'] > 0) {
            $messageAge .= " y ".$date['days'] . ' día' . ($date['days'] > 1 ? 's' : '') . ' ';
        }
        return $messageAge;
    }
    



    //formato ==> (fecha ahora, fecha a calcular) Y-d-m 
    public function calculateDaysDifference(string $startDate, string $endDate, string $dateFormat = 'Y-m-d') {
        $start = DateTime::createFromFormat($dateFormat, $startDate);
        $end = DateTime::createFromFormat($dateFormat, $endDate);
    
        if ($start && $end) {
            $interval = $start->diff($end);
            return $interval->days;
        }
        return 0; // En caso de error, por ejemplo, si las fechas son inválidas
    }
    

    
}
