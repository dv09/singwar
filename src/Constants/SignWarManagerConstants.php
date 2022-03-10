<?php

namespace App\Constants;

class SignWarManagerConstants
{
    //MENSAJES DE RESULTADO...
    const ALREADY_WINNER = "The firm is already a winner...";
    const NEVER_WINNER = "The firm can never be a winner...";
    const JUDMENT_IS_TIED = "The judgment is tied...";

    //MENSAJES DE ERROR...
    const ONLY_ONE_QUAD = "Se debe indicar un (solo) caracter " . self::D["QUAD_DIGIT"];
    const ONLY_ONE_QUAD_SIGN = "Sólo una de las firmas puede contener el caracter " . self::D["QUAD_DIGIT"];
    const NO_RIGHT_VALIDATED_SIGN = "Las firmas no se han validado correctamente, mensaje:";
    const NO_RIGHT_INPUT_DATA = "Los datos de entrada son incorrectos:";
    const MAX_SIGN_LENGTH = "El número de dígitos de la firma no puede exceder los 3 dígitos";
    const SIGN_VALIDATION_ERROR = "Error en validación de la firma";
    const NO_REG_SIGNER = "Firmante no registrado";
    const PARTY_DATA_LOAD_ERROR = "Error al cargar datos de la parte";

    //OTRAS CONSTANTES...
    const ROL = "ROL";
    const SIGN = "SIGN";
    const ROLS = ["PLAINTIFF" => "PLAINTIFF", "DEFENDANT" => "DEFENDANT"];
    const D = [
        "KING_DIGIT" => "K",
        "VALIDATOR_DIGIT" => "V",
        "NOTARY_DIGIT" => "N",
        "QUAD_DIGIT" => "#"
    ];
}