<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Chamada da api Usuario
 *
 * User: Gelvazio Camargo
 * Date: 11/08/2022
 * Time: 21:50:00
 */
require_once("ControllerApiBase.php");
class ControllerApiAuxilioEmergencial extends ControllerApiBase
{

    public function getAuxilios(Request $request, /*@var $response MessageInterface */ Response $response, array $args)
    {
    
        $body = $request->getParsedBody();
        
        $codigoibge = isset($body["codigoibge"]) ? $body["codigoibge"] : 4214805;
        $mesAno     = isset($body["mesano"]) ? $body["mesano"] : 202204;
        $pagina     = isset($body["pagina"]) ? $body["pagina"] : 1;
        
        $sSql = " select * 
                    from auxilioemergencial 
                   where codigoibge = $codigoibge
                     and mesano = $mesAno 
                     and pagina = $pagina 
                   limit 100 ";

        $aDados = $this->getQuery()->selectAll($sSql);

        return $response->withJson($aDados, 200);
    }
    
    public function getAuxiliosTest(Request $request, /*@var $response MessageInterface */ Response $response, array $args)
    {
        $dados = new stdClass();
        $dados->headers = $request->headers();

        return $response->withJson($dados, 200);
    }
    
    private function getDadosAuxilio($mesano, $codigoibge, $pagina)
    {

        $endpoint = "https://api.portaldatransparencia.gov.br/api-de-dados/auxilio-emergencial-beneficiario-por-municipio";

        $params = array(
            'codigoIbge' => $codigoibge,
            'mesAno' => $mesano,
            'pagina' => $pagina
        );

        $url = $endpoint . '?' . http_build_query($params);

        $client = curl_init($endpoint);

        curl_setopt($client, CURLOPT_URL, $url);

        $headers = ['chave-api-dados: e87c65b7590a28a987705526d3812c4a'];

        curl_setopt($client, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($client, CURLOPT_CUSTOMREQUEST, "GET");

        $response = curl_exec($client);

        if (!$response) {
            $erro = curl_error($client);
        }

        $oDados = $response;

        curl_close($client);

        return $oDados;
    }

    private function getDadosAuxilioPorPagina($pagina)
    {

        if ($pagina == 2) {
            return '[
            {
                "id": -948700844,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.347.489-**",
                    "nis": "13486922725",
                    "nome": "ELIANE FERREIRA"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                "enquadramentoAuxilioEmergencial": "CADUNICO",
                "valor": 1200.00,
                "numeroParcela": "4ª"
            },
            {
                "id": -946740267,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.345.269-**",
                    "nis": "00000000000",
                    "nome": "ODAIR DE CASTRO"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Não há",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 600.00,
                "numeroParcela": "5ª"
            },
            {
                "id": -946740266,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.345.269-**",
                    "nis": "00000000000",
                    "nome": "ODAIR DE CASTRO"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Não há",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 600.00,
                "numeroParcela": "3ª"
            },
            {
                "id": -938495685,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.523.749-**",
                    "nis": "00000000000",
                    "nome": "MAICON PURCINO"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Não há",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 300.00,
                "numeroParcela": "7ª"
            },
            {
                "id": -938495684,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.523.749-**",
                    "nis": "00000000000",
                    "nome": "MAICON PURCINO"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Não há",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 300.00,
                "numeroParcela": "9ª"
            },
            {
                "id": -938495680,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.523.749-**",
                    "nis": "00000000000",
                    "nome": "MAICON PURCINO"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Não há",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 300.00,
                "numeroParcela": "8ª"
            },
            {
                "id": -922468015,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.308.129-**",
                    "nis": "00000000000",
                    "nome": "FABIOLA BRIDAROLLI CONCOLATO"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 600.00,
                "numeroParcela": "4ª"
            },
            {
                "id": -922468014,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.308.129-**",
                    "nis": "00000000000",
                    "nome": "FABIOLA BRIDAROLLI CONCOLATO"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 600.00,
                "numeroParcela": "5ª"
            },
            {
                "id": -918014987,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.929.459-**",
                    "nis": "00000000000",
                    "nome": "ELAINE CRISTINA DE LIMA"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 1200.00,
                "numeroParcela": "5ª"
            },
            {
                "id": -918014984,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.929.459-**",
                    "nis": "00000000000",
                    "nome": "ELAINE CRISTINA DE LIMA"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 1200.00,
                "numeroParcela": "4ª"
            },
            {
                "id": -915812399,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.234.339-**",
                    "nis": "00000000000",
                    "nome": "SILVIO LUIS PORTO"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 600.00,
                "numeroParcela": "5ª"
            },
            {
                "id": -915774857,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.234.339-**",
                    "nis": "00000000000",
                    "nome": "SILVIO LUIS PORTO"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 600.00,
                "numeroParcela": "4ª"
            },
            {
                "id": -914587363,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.473.729-**",
                    "nis": "00000000000",
                    "nome": "MARCELO CUNHA"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Não há",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 300.00,
                "numeroParcela": "7ª"
            },
            {
                "id": -914587362,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.473.729-**",
                    "nis": "00000000000",
                    "nome": "MARCELO CUNHA"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Não há",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 300.00,
                "numeroParcela": "9ª"
            },
            {
                "id": -910318409,
                "mesDisponibilizacao": "01/2021",
                "beneficiario": {
                    "cpfFormatado": "***.111.369-**",
                    "nis": "00000000000",
                    "nome": "RENATO HERMANN"
                },
                "responsavelAuxilioEmergencial": {
                    "cpfFormatado": "",
                    "nis": "-2",
                    "nome": "Não se aplica"
                },
                "municipio": {
                    "codigoIBGE": "4214805",
                    "nomeIBGE": "RIO DO SUL",
                    "codigoRegiao": "4",
                    "nomeRegiao": "SUL",
                    "pais": "BRASIL",
                    "uf": {
                        "sigla": "SANTA CATARINA",
                        "nome": "SC"
                    }
                },
                "situacaoAuxilioEmergencial": "Não há",
                "enquadramentoAuxilioEmergencial": "EXTRACAD",
                "valor": 600.00,
                "numeroParcela": "3ª"
            }
        ]';
        } else if ($pagina == 1) {
            return '[
                {
                    "id": -1828656749,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.801.640-**",
                        "nis": "16026752243",
                        "nome": "ALINE SILVA DE OLIVEIRA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "***.801.640-**",
                        "nis": "16026752243",
                        "nome": "ALINE SILVA DE OLIVEIRA"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "",
                    "enquadramentoAuxilioEmergencial": "BOLSA FAMILIA",
                    "valor": 2400.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -1711107875,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.476.329-**",
                        "nis": "15951229271",
                        "nome": "LEONARDO CLAUDINO DE SOUZA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "***.054.679-**",
                        "nis": "16274512803",
                        "nome": "JANINE EDUARDA RIBEIRO DA SILVA"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "",
                    "enquadramentoAuxilioEmergencial": "BOLSA FAMILIA",
                    "valor": 300.00,
                    "numeroParcela": "1ª"
                },
                {
                    "id": -1686346059,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.054.679-**",
                        "nis": "16274512803",
                        "nome": "JANINE EDUARDA RIBEIRO DA SILVA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "***.054.679-**",
                        "nis": "16274512803",
                        "nome": "JANINE EDUARDA RIBEIRO DA SILVA"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "",
                    "enquadramentoAuxilioEmergencial": "BOLSA FAMILIA",
                    "valor": 1200.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -1032177697,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.345.269-**",
                        "nis": "00000000000",
                        "nome": "ODAIR DE CASTRO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -965704311,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.162.899-**",
                        "nis": "00000000000",
                        "nome": "GUILHERME HENRIQUE DE BORBA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -962949540,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.181.089-**",
                        "nis": "00000000000",
                        "nome": "GILBERTO CESAR DE ALMEIDA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -962949539,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.181.089-**",
                        "nis": "00000000000",
                        "nome": "GILBERTO CESAR DE ALMEIDA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -953435121,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.162.899-**",
                        "nis": "00000000000",
                        "nome": "GUILHERME HENRIQUE DE BORBA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -952440535,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.484.579-**",
                        "nis": "00000000000",
                        "nome": "WASHINGTON LOCKS BATISTA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -950461390,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.252.882-**",
                        "nis": "00000000000",
                        "nome": "ALYCE REYS CARVALHO GOMES"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "2ª"
                },
                {
                    "id": -950461389,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.252.882-**",
                        "nis": "00000000000",
                        "nome": "ALYCE REYS CARVALHO GOMES"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "3ª"
                },
                {
                    "id": -950426931,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.252.882-**",
                        "nis": "00000000000",
                        "nome": "ALYCE REYS CARVALHO GOMES"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -950426929,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.252.882-**",
                        "nis": "00000000000",
                        "nome": "ALYCE REYS CARVALHO GOMES"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -948734889,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.347.489-**",
                        "nis": "13486922725",
                        "nome": "ELIANE FERREIRA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "CADUNICO",
                    "valor": 1200.00,
                    "numeroParcela": "3ª"
                },
                {
                    "id": -948700846,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.347.489-**",
                        "nis": "13486922725",
                        "nome": "ELIANE FERREIRA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "CADUNICO",
                    "valor": 1200.00,
                    "numeroParcela": "5ª"
                }
            ]';
        } else if ($pagina == 3) {
            return '[
                {
                    "id": -910318408,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.111.369-**",
                        "nis": "00000000000",
                        "nome": "RENATO HERMANN"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -903271597,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.471.371-**",
                        "nis": "00000000000",
                        "nome": "PATRICK DE OLIVEIRA MOURA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -903271596,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.471.371-**",
                        "nis": "00000000000",
                        "nome": "PATRICK DE OLIVEIRA MOURA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -885645903,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.549.069-**",
                        "nis": "00000000000",
                        "nome": "MARILEUSA VIEIRA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 1200.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -878320737,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.663.809-**",
                        "nis": "00000000000",
                        "nome": "ISADORA CANI GROHS"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -878320736,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.663.809-**",
                        "nis": "00000000000",
                        "nome": "ISADORA CANI GROHS"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -878025748,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.099.889-**",
                        "nis": "00000000000",
                        "nome": "CARLOS JOSE MARANGONI"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -878025747,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.099.889-**",
                        "nis": "00000000000",
                        "nome": "CARLOS JOSE MARANGONI"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -875927816,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.137.999-**",
                        "nis": "00000000000",
                        "nome": "TAINA ALVINA STEINBACH"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 1200.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -875890216,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.137.999-**",
                        "nis": "00000000000",
                        "nome": "TAINA ALVINA STEINBACH"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 1200.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -875890215,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.137.999-**",
                        "nis": "00000000000",
                        "nome": "TAINA ALVINA STEINBACH"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 1200.00,
                    "numeroParcela": "2ª"
                },
                {
                    "id": -872083743,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.917.619-**",
                        "nis": "00000000000",
                        "nome": "ANGELICA BEATRIZ NOVAK"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -863649824,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.473.729-**",
                        "nis": "00000000000",
                        "nome": "MARCELO CUNHA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "8ª"
                },
                {
                    "id": -863620309,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.473.729-**",
                        "nis": "00000000000",
                        "nome": "MARCELO CUNHA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "6ª"
                },
                {
                    "id": -861807177,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.051.119-**",
                        "nis": "00000000000",
                        "nome": "WILLIAN DE AMORIM"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                }
            ]';
        } else if ($pagina == 4) {
            return '[
                {
                    "id": -860695450,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.294.779-**",
                        "nis": "00000000000",
                        "nome": "PAMELA INGRID PINHEIRO SANTOS"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "3ª"
                },
                {
                    "id": -860695449,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.294.779-**",
                        "nis": "00000000000",
                        "nome": "PAMELA INGRID PINHEIRO SANTOS"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "2ª"
                },
                {
                    "id": -858957196,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.111.369-**",
                        "nis": "00000000000",
                        "nome": "RENATO HERMANN"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -857614865,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.949.729-**",
                        "nis": "00000000000",
                        "nome": "MARLENA SELHORST"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -857577207,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.949.729-**",
                        "nis": "00000000000",
                        "nome": "MARLENA SELHORST"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -853906400,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.341.599-**",
                        "nis": "00000000000",
                        "nome": "CARLOS FELIPE GONZALEZ AGUDELO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -852764426,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.137.999-**",
                        "nis": "00000000000",
                        "nome": "TAINA ALVINA STEINBACH"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 1200.00,
                    "numeroParcela": "3ª"
                },
                {
                    "id": -846904591,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.957.639-**",
                        "nis": "00000000000",
                        "nome": "PAOLA ALVES PONCIANO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -846904590,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.957.639-**",
                        "nis": "00000000000",
                        "nome": "PAOLA ALVES PONCIANO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -846883466,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.957.639-**",
                        "nis": "00000000000",
                        "nome": "PAOLA ALVES PONCIANO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "2ª"
                },
                {
                    "id": -846883465,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.957.639-**",
                        "nis": "00000000000",
                        "nome": "PAOLA ALVES PONCIANO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "3ª"
                },
                {
                    "id": -844279183,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.677.069-**",
                        "nis": "00000000000",
                        "nome": "NATALIA RODRIGUES"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -843890598,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.521.959-**",
                        "nis": "00000000000",
                        "nome": "MARISE IAHN PRIEBE"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -838307279,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.939.089-**",
                        "nis": "00000000000",
                        "nome": "CLAIR HAMES"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -838269652,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.939.089-**",
                        "nis": "00000000000",
                        "nome": "CLAIR HAMES"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                }
            ]';
        } else if ($pagina == 5) {
            return '[
                {
                    "id": -835959621,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.294.779-**",
                        "nis": "00000000000",
                        "nome": "PAMELA INGRID PINHEIRO SANTOS"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -835959620,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.294.779-**",
                        "nis": "00000000000",
                        "nome": "PAMELA INGRID PINHEIRO SANTOS"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -834904287,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.353.779-**",
                        "nis": "00000000000",
                        "nome": "JESSICA CRISTINA SCHAFRANSKI MOREIRA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 1200.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -834904286,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.353.779-**",
                        "nis": "00000000000",
                        "nome": "JESSICA CRISTINA SCHAFRANSKI MOREIRA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 1200.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -834904284,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.353.779-**",
                        "nis": "00000000000",
                        "nome": "JESSICA CRISTINA SCHAFRANSKI MOREIRA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 1200.00,
                    "numeroParcela": "3ª"
                },
                {
                    "id": -830187938,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.018.319-**",
                        "nis": "00000000000",
                        "nome": "JOSIANE EZIDRA KESKE CARDOSO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "9ª"
                },
                {
                    "id": -826528369,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.064.610-**",
                        "nis": "00000000000",
                        "nome": "DALVA ALVES DA ROSA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -826493935,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.780.059-**",
                        "nis": "00000000000",
                        "nome": "DAIANA TEREZINHA DE SOUZA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 1200.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -826493934,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.780.059-**",
                        "nis": "00000000000",
                        "nome": "DAIANA TEREZINHA DE SOUZA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 1200.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -826490761,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.064.610-**",
                        "nis": "00000000000",
                        "nome": "DALVA ALVES DA ROSA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -821491114,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.133.349-**",
                        "nis": "00000000000",
                        "nome": "JAIR PLOTECKER"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -821491113,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.133.349-**",
                        "nis": "00000000000",
                        "nome": "JAIR PLOTECKER"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -818952893,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.521.959-**",
                        "nis": "00000000000",
                        "nome": "MARISE IAHN PRIEBE"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -817880855,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.620.259-**",
                        "nis": "00000000000",
                        "nome": "PAMELA CRISTINE FILAGRANA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -817359507,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.301.249-**",
                        "nis": "00000000000",
                        "nome": "THIAGO GOIS"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                }
            ]';
        } else if ($pagina == 6) {
            return '[
                {
                    "id": -817321773,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.301.249-**",
                        "nis": "00000000000",
                        "nome": "THIAGO GOIS"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -811016868,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.014.239-**",
                        "nis": "00000000000",
                        "nome": "IVONETE STAROWSKI"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "7ª"
                },
                {
                    "id": -810979277,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.014.239-**",
                        "nis": "00000000000",
                        "nome": "IVONETE STAROWSKI"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "9ª"
                },
                {
                    "id": -810979274,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.014.239-**",
                        "nis": "00000000000",
                        "nome": "IVONETE STAROWSKI"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "8ª"
                },
                {
                    "id": -809436650,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.557.619-**",
                        "nis": "21061480102",
                        "nome": "OSANIA CORREA MAZZINI"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "CADUNICO",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -808350420,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.018.319-**",
                        "nis": "00000000000",
                        "nome": "JOSIANE EZIDRA KESKE CARDOSO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "8ª"
                },
                {
                    "id": -808331796,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.018.319-**",
                        "nis": "00000000000",
                        "nome": "JOSIANE EZIDRA KESKE CARDOSO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "7ª"
                },
                {
                    "id": -805270267,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.226.099-**",
                        "nis": "00000000000",
                        "nome": "CELITA DA SILVA AMADO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "9ª"
                },
                {
                    "id": -802370759,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.634.319-**",
                        "nis": "00000000000",
                        "nome": "SIRLENI BENJAMIN DE SOUZA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "8ª"
                },
                {
                    "id": -794643185,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.620.259-**",
                        "nis": "00000000000",
                        "nome": "PAMELA CRISTINE FILAGRANA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Pagamento bloqueado ou cancelado",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -794350156,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.184.349-**",
                        "nis": "00000000000",
                        "nome": "CAICARA HOBOLD"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "2ª"
                },
                {
                    "id": -794350155,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.184.349-**",
                        "nis": "00000000000",
                        "nome": "CAICARA HOBOLD"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "3ª"
                },
                {
                    "id": -794350154,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.184.349-**",
                        "nis": "00000000000",
                        "nome": "CAICARA HOBOLD"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "4ª"
                },
                {
                    "id": -794350153,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.184.349-**",
                        "nis": "00000000000",
                        "nome": "CAICARA HOBOLD"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                },
                {
                    "id": -788256366,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.248.269-**",
                        "nis": "00000000000",
                        "nome": "MICHAEL DOUGLAS MENDES"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "6ª"
                }
            ]';
        } else if ($pagina == 7) {
            return '[
                {
                    "id": -788256363,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.248.269-**",
                        "nis": "00000000000",
                        "nome": "MICHAEL DOUGLAS MENDES"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "9ª"
                },
                {
                    "id": -788218664,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.248.269-**",
                        "nis": "00000000000",
                        "nome": "MICHAEL DOUGLAS MENDES"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "8ª"
                },
                {
                    "id": -788218662,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.248.269-**",
                        "nis": "00000000000",
                        "nome": "MICHAEL DOUGLAS MENDES"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "7ª"
                },
                {
                    "id": -778432459,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.226.099-**",
                        "nis": "00000000000",
                        "nome": "CELITA DA SILVA AMADO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "7ª"
                },
                {
                    "id": -778432457,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.226.099-**",
                        "nis": "00000000000",
                        "nome": "CELITA DA SILVA AMADO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "8ª"
                },
                {
                    "id": -778405481,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.226.099-**",
                        "nis": "00000000000",
                        "nome": "CELITA DA SILVA AMADO"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "6ª"
                },
                {
                    "id": -774333225,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.634.319-**",
                        "nis": "00000000000",
                        "nome": "SIRLENI BENJAMIN DE SOUZA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "9ª"
                },
                {
                    "id": -774333223,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.634.319-**",
                        "nis": "00000000000",
                        "nome": "SIRLENI BENJAMIN DE SOUZA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "7ª"
                },
                {
                    "id": -765888658,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.469.119-**",
                        "nis": "00000000000",
                        "nome": "CESSO BIAVA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "9ª"
                },
                {
                    "id": -764289506,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.723.749-**",
                        "nis": "00000000000",
                        "nome": "MARINA STREY"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "7ª"
                },
                {
                    "id": -764289505,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.723.749-**",
                        "nis": "00000000000",
                        "nome": "MARINA STREY"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "8ª"
                },
                {
                    "id": -738451058,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.469.119-**",
                        "nis": "00000000000",
                        "nome": "CESSO BIAVA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "8ª"
                },
                {
                    "id": -738451055,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.469.119-**",
                        "nis": "00000000000",
                        "nome": "CESSO BIAVA"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Valor devolvido à União.",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "7ª"
                },
                {
                    "id": -735122904,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.723.749-**",
                        "nis": "00000000000",
                        "nome": "MARINA STREY"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 300.00,
                    "numeroParcela": "9ª"
                },
                {
                    "id": -734696669,
                    "mesDisponibilizacao": "01/2021",
                    "beneficiario": {
                        "cpfFormatado": "***.823.579-**",
                        "nis": "00000000000",
                        "nome": "MATHEUS CARDOSO SCHMIDT"
                    },
                    "responsavelAuxilioEmergencial": {
                        "cpfFormatado": "",
                        "nis": "-2",
                        "nome": "Não se aplica"
                    },
                    "municipio": {
                        "codigoIBGE": "4214805",
                        "nomeIBGE": "RIO DO SUL",
                        "codigoRegiao": "4",
                        "nomeRegiao": "SUL",
                        "pais": "BRASIL",
                        "uf": {
                            "sigla": "SANTA CATARINA",
                            "nome": "SC"
                        }
                    },
                    "situacaoAuxilioEmergencial": "Não há",
                    "enquadramentoAuxilioEmergencial": "EXTRACAD",
                    "valor": 600.00,
                    "numeroParcela": "5ª"
                }
            ]';
        } else {
            if ($pagina > 10) {
                return '[Sem dados...]';
            }

            $aDados = array();
            $aDados[10] = '[{"id":-643680023,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.194.369-**","nis":"00000000000","nome":"MICHELE RODRIGUES DE OLIVEIRA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":1200.00,"numeroParcela":"4ª"},{"id":-642623988,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.667.799-**","nis":"00000000000","nome":"MILENA TENFEN HELLMANN"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"4ª"},{"id":-642623987,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.667.799-**","nis":"00000000000","nome":"MILENA TENFEN HELLMANN"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-634764914,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.928.249-**","nis":"00000000000","nome":"YAGO RUAN BALTAZAR BOULDRES SALGADO"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-631742339,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.194.369-**","nis":"00000000000","nome":"MICHELE RODRIGUES DE OLIVEIRA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":1200.00,"numeroParcela":"3ª"},{"id":-631742337,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.194.369-**","nis":"00000000000","nome":"MICHELE RODRIGUES DE OLIVEIRA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":1200.00,"numeroParcela":"5ª"},{"id":-624856956,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.124.259-**","nis":"00000000000","nome":"ORJANA APARECIDA DE CAMPESTRINI"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":1200.00,"numeroParcela":"4ª"},{"id":-624856955,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.124.259-**","nis":"00000000000","nome":"ORJANA APARECIDA DE CAMPESTRINI"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":1200.00,"numeroParcela":"5ª"},{"id":-622371481,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.878.989-**","nis":"00000000000","nome":"PAULO VERGILIO SELHORST"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"4ª"},{"id":-622371480,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.878.989-**","nis":"00000000000","nome":"PAULO VERGILIO SELHORST"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"3ª"},{"id":-622371479,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.878.989-**","nis":"00000000000","nome":"PAULO VERGILIO SELHORST"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-606251266,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.850.049-**","nis":"00000000000","nome":"JANETE DE CASSIA DA SILVA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"}]';
            $aDados[9]  = '[{"id":-689442562,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.924.639-**","nis":"00000000000","nome":"MARLETE DA SILVA NAVARRO LINS"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Valor devolvido à União.","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"3ª"},{"id":-689410003,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.924.639-**","nis":"00000000000","nome":"MARLETE DA SILVA NAVARRO LINS"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Valor devolvido à União.","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-683001411,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.436.309-**","nis":"00000000000","nome":"CAROLINE CARDOSO MELO"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":1200.00,"numeroParcela":"5ª"},{"id":-678326673,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.936.629-**","nis":"00000000000","nome":"FRANCIELE FERREIRA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":1200.00,"numeroParcela":"4ª"},{"id":-678289221,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.936.629-**","nis":"00000000000","nome":"FRANCIELE FERREIRA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":1200.00,"numeroParcela":"5ª"},{"id":-663662444,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.998.669-**","nis":"00000000000","nome":"VILMAR CATAFESTA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"4ª"},{"id":-663662443,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.998.669-**","nis":"00000000000","nome":"VILMAR CATAFESTA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-662553258,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.936.629-**","nis":"00000000000","nome":"FRANCIELE FERREIRA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":1200.00,"numeroParcela":"3ª"},{"id":-650852898,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.938.799-**","nis":"00000000000","nome":"TIAGO FERNANDES DE GODOY"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Não há","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"4ª"},{"id":-650815293,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.938.799-**","nis":"00000000000","nome":"TIAGO FERNANDES DE GODOY"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Não há","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"2ª"},{"id":-650815292,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.938.799-**","nis":"00000000000","nome":"TIAGO FERNANDES DE GODOY"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Não há","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-650795402,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.938.799-**","nis":"00000000000","nome":"TIAGO FERNANDES DE GODOY"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Não há","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"3ª"},{"id":-649447010,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.726.139-**","nis":"00000000000","nome":"CHARLIENE CERCILIO"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-649447009,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.726.139-**","nis":"00000000000","nome":"CHARLIENE CERCILIO"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"4ª"},{"id":-649447008,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.726.139-**","nis":"00000000000","nome":"CHARLIENE CERCILIO"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"3ª"}]';
            $aDados[8]  = '[{"id":-718607789,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.440.119-**","nis":"00000000000","nome":"MARIZETE APARECIDA DOS SANTOS CE"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Valor devolvido à União.","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"3ª"},{"id":-718570242,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.440.119-**","nis":"00000000000","nome":"MARIZETE APARECIDA DOS SANTOS CE"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Valor devolvido à União.","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-718570241,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.440.119-**","nis":"00000000000","nome":"MARIZETE APARECIDA DOS SANTOS CE"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Valor devolvido à União.","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"4ª"},{"id":-717328738,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.646.659-**","nis":"12484212013","nome":"VALDONIR DEMETRIO"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Não há","enquadramentoAuxilioEmergencial":"CADUNICO","valor":600.00,"numeroParcela":"5ª"},{"id":-717291099,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.646.659-**","nis":"12484212013","nome":"VALDONIR DEMETRIO"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Não há","enquadramentoAuxilioEmergencial":"CADUNICO","valor":600.00,"numeroParcela":"2ª"},{"id":-708857632,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.909.269-**","nis":"00000000000","nome":"JEFFERSON RIBEIRO SABKA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Não há","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-708857631,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.909.269-**","nis":"00000000000","nome":"JEFFERSON RIBEIRO SABKA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Não há","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"4ª"},{"id":-704746198,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.832.869-**","nis":"00000000000","nome":"GABRIELA CAROLINE HOFFER DA SILVA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Não há","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-703300099,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.409.809-**","nis":"00000000000","nome":"JESSICA FINARDI"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":1200.00,"numeroParcela":"5ª"},{"id":-699459959,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.646.659-**","nis":"12484212013","nome":"VALDONIR DEMETRIO"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Não há","enquadramentoAuxilioEmergencial":"CADUNICO","valor":600.00,"numeroParcela":"4ª"},{"id":-699459958,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.646.659-**","nis":"12484212013","nome":"VALDONIR DEMETRIO"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Não há","enquadramentoAuxilioEmergencial":"CADUNICO","valor":600.00,"numeroParcela":"3ª"},{"id":-696761995,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.998.499-**","nis":"00000000000","nome":"CHARLES RAMOS POEPKEN"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-696761994,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.998.499-**","nis":"00000000000","nome":"CHARLES RAMOS POEPKEN"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"4ª"},{"id":-694490042,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.697.629-**","nis":"00000000000","nome":"ORLANDO PRADA"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"5ª"},{"id":-689442563,"mesDisponibilizacao":"01/2021","beneficiario":{"cpfFormatado":"***.924.639-**","nis":"00000000000","nome":"MARLETE DA SILVA NAVARRO LINS"},"responsavelAuxilioEmergencial":{"cpfFormatado":"","nis":"-2","nome":"Não se aplica"},"municipio":{"codigoIBGE":"4214805","nomeIBGE":"RIO DO SUL","codigoRegiao":"4","nomeRegiao":"SUL","pais":"BRASIL","uf":{"sigla":"SANTA CATARINA","nome":"SC"}},"situacaoAuxilioEmergencial":"Pagamento bloqueado ou cancelado","enquadramentoAuxilioEmergencial":"EXTRACAD","valor":600.00,"numeroParcela":"4ª"}]';

            return $aDados[$pagina];
        }
    }

    public function cadastrarAuxilios(Request $request, Response $response, array $args) {
        // ibge Rio do Sul 
        $codigoibge = 4214805;
        $aListaAnos = $this->getListaAnos();
        $aListaDadosCadastrados = array();
        $aListaDadosInseridosNovos = array();
        $aListaDadosErroInserirNovos = array();
        
        foreach ($aListaAnos as $mesano){
            $contador = 1;
            $totalPagina = 1;    
            $totalPagina = 50;
            while ($contador <= $totalPagina) {
                $pagina = $contador;
                
                $sSql = "select * 
                           from auxilioemergencial 
                          where codigoibge = $codigoibge
                            and mesano = $mesano 
                            and pagina = $pagina";
        
                $aDados = $this->getQuery()->selectAll($sSql);
                
                $aListaDadosCadastradosAtual = array(
                    "codigoibge" => $codigoibge,
                    "mesano" => $mesano,
                    "pagina" => $pagina
                );
                
                if(count($aDados)){
                    array_push($aListaDadosCadastrados, $aListaDadosCadastradosAtual);
                } else {
                    // Busca os dados e tenta inserir no sistema se existirem
                    if($oDadosAuxilio = $this->insereDadosAuxilioEmergencial($mesano, $codigoibge, $pagina)){
                        array_push($aListaDadosInseridosNovos, $oDadosAuxilio);                        
                    } else {
                        array_push($aListaDadosErroInserirNovos, $aListaDadosCadastradosAtual);
                    }                    
                }
                $contador++;
            }
        }
    
        $aDados = array("listaDadosCadastrados" => $aListaDadosCadastrados,
              "listaDadosInseridosNovos" => $aListaDadosInseridosNovos,
              "listaDadosErroInserirNovos" => $aListaDadosErroInserirNovos);
        
        return $response->withJson($aDados, 200);
    }
    
    private function insereDadosAuxilioEmergencial($mesano, $codigoibge, $pagina){
        
        $oDadosAuxilio = $this->getDadosAuxilio($mesano, $codigoibge, $pagina);
    
        if($oDadosAuxilio){
            $oDadosAuxilio = json_decode($oDadosAuxilio);
        
            if(is_array($oDadosAuxilio) && count($oDadosAuxilio)){
                // sql
                $sSql = 'insert into auxilioemergencial(codigoibge, mesano, pagina, dados)
                        values(' . $codigoibge . ', ' . $mesano . ',
                        ' . $pagina . ', \'' . json_encode($oDadosAuxilio) . '\');';
            
                if($this->getQuery()->executaQuery($sSql, true)){
                    return $oDadosAuxilio;
                }
            }
        }
        
        return false;
    }
    
    private function getListaAnos(){
        
        return array(202102);
        
        return array(
            202004
            ,202005
            ,202006
            ,202007
            ,202008
            ,202009
            ,202010
            ,202011
            ,202012
            //,202101 => ja foi...
            //,202102
            ,202103
            ,202104
            ,202105
            ,202106
            ,202107
            ,202108
            ,202109
            ,202110
            ,202111
            ,202112
            ,202201
            ,202202
            ,202203
            ,202204
            ,202205
            ,202206
            ,202207
            ,202208
        );
    }
    
//     public function getAuxiliosApi(Request $request, Response $response, array $args) {
//         // ibge Rio do Sul 
//         $codigoibge = 4214805;
//         $aListaAnos = $this->getListaAnos();
//         $aListaDadosCadastrados = array();
//         $aListaDadosInseridosNovos = array();
//         $aListaDadosErroInserirNovos = array();
//        
// define("QUEBRA_LINHA", '
// ');
//    
//         $sSql = "";
//         foreach ($aListaAnos as $mesano){
//             $contador = 1;
//             $totalPagina = 1;
//             while ($contador <= $totalPagina) {
//                 $pagina = $contador;               
//                 $aListaDadosCadastradosAtual = array(
//                     "codigoibge" => $codigoibge,
//                     "mesano" => $mesano,
//                     "pagina" => $pagina
//                 );
//
//                 // Busca os dados
//                 $oDadosAuxilio = $this->getDadosAuxilio($mesano, $codigoibge, $pagina);
//    
//                 if($oDadosAuxilio){
//                     array_push($aListaDadosCadastrados, $aListaDadosCadastradosAtual);
//                    
//                     $oDadosAuxilio = json_decode($oDadosAuxilio);
//        
//                     if(is_array($oDadosAuxilio) && count($oDadosAuxilio)){
//                         // sql
//                         $sSql .= QUEBRA_LINHA . 'insert into auxilioemergencial(codigoibge, mesano, pagina, dados) values(' . $codigoibge . ', ' . $mesano . ',' . $pagina . ', \'' . json_encode($oDadosAuxilio) . '\');';
//                     }
//                 }
//                    
//                 $contador++;
//             }
//         }
//        
//         file_put_contents(Utils::getDirTempFile() . "/listaDadosCadastradosAtual.json", json_encode($aListaDadosCadastrados));
//        
//         return $response->withJson($aListaDadosCadastradosAtual, 200);
//     }
//    
}
