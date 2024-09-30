# Academia Da Neuro - Plugin para WordPress

## Descrição

Este plugin foi desenvolvido para WordPress utilizando a arquitetura MSVC (Modelo de Serviço e Controle de Visualização). A arquitetura MSVC é uma variação do padrão MVC tradicional, que separa a lógica de negócios, controle de fluxo e a camada de visualização em diferentes componentes, garantindo uma estrutura modular e de fácil manutenção.

## Arquitetura

A aplicação segue o fluxo descrito abaixo:

1. **Roteamento (`init.php`)**: O ponto de entrada da aplicação. Todas as requisições passam por este arquivo, que determina qual controlador será chamado com base na rota acessada.

2. **Controlador (`Controller`)**: O controlador processa a requisição recebida, interage com o serviço adequado e envia a resposta correta para a visualização. Ele age como um intermediário entre a camada de apresentação (View) e a lógica de negócios (Service).

3. **Serviço (`Service`)**: Contém a lógica de negócios da aplicação. Ele recebe as requisições do controlador e faz as operações necessárias, incluindo chamadas ao Model, se necessário.

4. **Modelo (`Model`)**: Responsável por interagir com o banco de dados. Ele realiza consultas, atualizações e outras operações no banco, e retorna os dados processados para o serviço.

5. **Visualização (`View`)**: A camada de apresentação da aplicação. Diferentemente das aplicações convencionais, neste plugin, a View retorna um shortcode que pode ser utilizado em qualquer plataforma que suporte shortcodes, como WordPress.

## Fluxo de Execução

1. O usuário faz uma requisição que é capturada pelo `init.php`.
2. O `init.php` encaminha a requisição para o controlador apropriado.
3. O controlador, com base na lógica de negócios, chama o serviço necessário.
4. O serviço interage com o modelo para obter ou manipular os dados no banco de dados.
5. Os dados são retornados para o serviço, que os processa conforme necessário.
6. O controlador recebe os dados do serviço e os envia para a visualização.
7. A visualização gera um shortcode correspondente que pode ser inserido em qualquer lugar do WordPress, exibindo os dados ao usuário final.

## Estrutura do Projeto

```plaintext
├── init.php                # Arquivo de roteamento principal e os (shortcodes)
├── controllers/            # Diretório contendo os controladores
├── services/               # Diretório contendo os serviços
├── models/                 # Diretório contendo os modelos
└── views/                  # Diretório contendo as visualizações 
```

## Requisitos

- PHP versão 7.4 ou superior
- WordPress versão 5.0 ou superior
- Banco de Dados MySQL/PostgreSQL
