<?php 

//import('/Database/ORM/orm.php', false, '/core');
core('DataBase/ORM/orm.php', false);
class BaseModel extends DataBase{


    public function getManyToManyRelationship(string $relatedTable, string $pivotTable,string $primaryKeyColumnPivot = null, string $primaryKeyColumnRelated = 'id') {
        if ($primaryKeyColumnPivot === null) {
            // Si no se proporciona un nombre de columna de pivote, asumimos una convención específica
            $pivotTableParts = explode('_', $pivotTable);
            $primaryKeyColumnPivot = $pivotTableParts[0] . '_id'; // Por ejemplo, user_id si el nombre de la tabla es users_has_roles
        }
    
        // Construir la consulta para recuperar los registros relacionados
        $this->prepare();
        return $this->select([$relatedTable.'.*'])
            ->from($relatedTable)
            ->join($pivotTable)
            ->on($relatedTable . '.' . $primaryKeyColumnRelated, $pivotTable . '.' . $primaryKeyColumnPivot);
    
        
    }
    
    
}