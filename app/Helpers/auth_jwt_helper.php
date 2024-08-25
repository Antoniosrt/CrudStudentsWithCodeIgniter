<?php

use CodeIgniter\HTTP\RequestInterface;
use Firebase\JWT\JWT;
use Config\Services;
use Firebase\JWT\Key;

/**
 * Função de ajuda para poder pegar o JWT do campo Authorization Bearer
 * @param string $authHeader
 * @return string
 * @throws Exception
 */
function getJWTFromHeader(string $authHeader) : string
{
    //valida se o cabeçalho existe e caso não ele retorna um erro
    if(!$authHeader){
        throw new Exception('Sem token de autorização!');
    }
    //retorna o token, visto que o Bearer vem com um espaço entre ele e o token
    return explode(' ', $authHeader)[1];
}

/**
 * @param RequestInterface $request
 * @throws Exception
 */
function validateJWT(RequestInterface $request){
    $authHeader = $request->getServer('HTTP_AUTHORIZATION');
    try{
        $jwtEncoded= getJWTFromHeader($authHeader);
        $jwtSecretKey = Services::getJWTSecretKey();
        $headers = ['HS256'];
        $jwtDecoded= JWT::decode($jwtEncoded,new Key($jwtSecretKey,'HS256'));

    }catch (Exception $exception){
        throw new Exception($exception->getMessage());
    }
}