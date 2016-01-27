<?php

namespace CorePHP\Libraries;

class QueryMap {

    public $queryList = array();

    public function administradoresQuery(){
        $this->queryList['administradores'] = array(
            "getItem" => "SELECT * FROM administradores WHERE idAdministrador = [[id]]",
            "getAllItems" => "SELECT * FROM administradores",
            "insertItem" => "INSERT INTO administradores (usuario,passwd) VALUES ('[[usuario]]','[[passwd]]')",
            "updateItem" => "UPDATE administradores SET [[data]] WHERE idAdministrador = [[id]]",
            "deleteItem" => "DELETE FROM administradores WHERE idAdministrador = [[id]]",
            "getLastItem" => "SELECT MAX(idAdministrador) AS 'last' FROM administradores"
        );
    }

    public function comprasQuery(){
        $this->queryList['compras'] = array(
            "getItem" => "SELECT * FROM compras WHERE idCompra = [[id]]",
            "getAllItems" => "SELECT * FROM compras",
            "insertItem" => "INSERT INTO compras (fecha) VALUES ('[[fecha]]')",
            "updateItem" => "UPDATE compras SET [[data]] WHERE idCompra = [[id]]",
            "deleteItem" => "DELETE FROM compras WHERE idCompra = [[id]]",
            "getLastItem" => "SELECT MAX(idCompra) AS 'last' FROM compras"
        );
    }

    public function fotosQuery(){
        $this->queryList['fotos'] = array(
            "getItem" => "SELECT * FROM fotos WHERE idFoto = [[id]]",
            "getAllItems" => "SELECT * FROM fotos",
            "insertItem" => "INSERT INTO fotos (archivo,puntointeres,usuario) VALUES ('[[archivo]]',[[puntointeres]],[[usuario]])",
            "updateItem" => "UPDATE fotos SET [[data]] WHERE idFoto = [[id]]",
            "deleteItem" => "DELETE FROM fotos WHERE idFoto = [[id]]",
            "getLastItem" => "SELECT MAX(idFoto) AS 'last' FROM fotos"
        );
    }

    public function fotoscomprasQuery(){
        $this->queryList['fotoscompras'] = array(
            "getItem" => "SELECT * FROM fotoscompras WHERE idFotosCompra = [[id]]",
            "getAllItems" => "SELECT * FROM fotoscompras",
            "insertItem" => "INSERT INTO fotoscompras (compra,foto,copias,preciounitario) VALUES ([[compra]],[[foto]],[[copias]],[[preciounitario]])",
            "updateItem" => "UPDATE fotoscompras SET [[data]] WHERE idFotosCompra = [[id]]",
            "deleteItem" => "DELETE FROM fotoscompras WHERE idFotosCompra = [[id]]",
            "getLastItem" => "SELECT MAX(idFotosCompra) AS 'last' FROM fotoscompras"
        );
    }

    public function fotostempQuery(){
        $this->queryList['fotostemp'] = array(
            "getItem" => "SELECT * FROM fotostemp WHERE idFotoTemp = [[id]]",
            "getAllItems" => "SELECT * FROM fotostemp",
            "insertItem" => "INSERT INTO fotostemp (foto,puntointeres) VALUES ('[[foto]]',[[puntointeres]])",
            "updateItem" => "UPDATE fotostemp SET [[data]] WHERE idFotoTemp = [[id]]",
            "deleteItem" => "DELETE FROM fotostemp WHERE idFotoTemp = [[id]]",
            "getLastItem" => "SELECT MAX(idFotoTemp) AS 'last' FROM fotostemp"
        );
    }

    public function marcosQuery(){
        $this->queryList['marcos'] = array(
            "getItem" => "SELECT * FROM marcos WHERE idMarco = [[id]]",
            "getAllItems" => "SELECT * FROM marcos",
            "insertItem" => "INSERT INTO marcos (archivo) VALUES ('[[archivo]]')",
            "updateItem" => "UPDATE marcos SET [[data]] WHERE idMarco = [[id]]",
            "deleteItem" => "DELETE FROM marcos WHERE idMarco = [[id]]",
            "getLastItem" => "SELECT MAX(idMarco) AS 'last' FROM marcos"
        );
    }

    public function preciossizeQuery(){
        $this->queryList['preciossize'] = array(
            "getItem" => "SELECT * FROM preciossize WHERE idPrecioSize = [[id]]",
            "getAllItems" => "SELECT * FROM preciossize",
            "insertItem" => "INSERT INTO preciossize (size,precio) VALUES ('[[size]]',[[precio]])",
            "updateItem" => "UPDATE preciossize SET [[data]] WHERE idPrecioSize = [[id]]",
            "deleteItem" => "DELETE FROM preciossize WHERE idPrecioSize = [[id]]",
            "getLastItem" => "SELECT MAX(idPrecioSize) AS 'last' FROM preciossize"
        );
    }

    public function puntosinteresQuery(){
        $this->queryList['puntosinteres'] = array(
            "getItem" => "SELECT * FROM puntosinteres WHERE idPuntoInteres = [[id]]",
            "getAllItems" => "SELECT * FROM puntosinteres",
            "insertItem" => "INSERT INTO puntosinteres (punto) VALUES ('[[punto]]')",
            "updateItem" => "UPDATE puntosinteres SET [[data]] WHERE idPuntoInteres = [[id]]",
            "deleteItem" => "DELETE FROM puntosinteres WHERE idPuntoInteres = [[id]]",
            "getLastItem" => "SELECT MAX(idPuntoInteres) AS 'last' FROM puntosinteres"
        );
    }

    public function usuariosQuery(){
        $this->queryList['usuarios'] = array(
            "getItem" => "SELECT * FROM usuarios WHERE idUsuario = [[id]]",
            "getAllItems" => "SELECT * FROM usuarios",
            "insertItem" => "INSERT INTO usuarios (codigo) VALUES ('[[codigo]]')",
            "updateItem" => "UPDATE usuarios SET [[data]] WHERE idUsuario = [[id]]",
            "deleteItem" => "DELETE FROM usuarios WHERE idUsuario = [[id]]",
            "getLastItem" => "SELECT MAX(idUsuario) AS 'last' FROM usuarios"
        );
    }

    /*add-function-model*/
}