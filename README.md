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

# Processo GitFlow

## Visão Geral

Este documento descreve o fluxo de trabalho Git para ACADEMIA DA NEUROCIENCIA. O objetivo é manter a estabilidade da `main`, garantindo que todo o código seja revisado antes de ser mergeado. Todas as mudanças na `production` devem ser feitas por meio de pull requests (PRs) associados a tasks no ClickUp e devem ser aprovadas por pelo menos um membro da equipe antes de serem mergeadas.

## Regras Gerais

- Todo trabalho deve ser feito em branches de feature que derivam da `production`.
- Cada pull request deve ser nomeado com o ID da issues do Github.
- Cada pull request deve receber pelo menos uma aprovação antes de ser mergeado.
- Incentivamos a prática de commits atômicos para facilitar a revisão de código.

## Fluxo de Trabalho

1. **Criar uma Branch de Feature**
    - Nomeie a branch de feature com o prefixo `feature/` seguido por uma breve descrição do que a branch contém.
    - Exemplo: `feature/melhorar-performance-api`

    ```sh
    git checkout production
    ```
    ```sh
    git pull origin production
    ```
    ```sh
    git checkout -b feature/nome-da-feature
    ```

2. **Implementar as Mudanças**
    - Faça commits frequentes e atômicos. Cada commit deve ter uma única responsabilidade clara.
    - Exemplo de commit:

    ```sh
    git add .
    ```
    ```sh
    git commit -m "https://github.com/lellyoliver/academiadaneuro/issues/8"
    ```

3. **Criar um Pull Request**
    - Quando a feature estiver completa, crie um pull request (PR) para a `production`.
    - Nomeie o PR com o ID da Issue do Github e uma breve descrição.
    - Exemplo: `8: Melhorar performance da API`
    - Adicione uma descrição detalhada sobre as mudanças implementadas.

4. **Revisão de Código**
    - Solicite a revisão do PR de pelo menos um membro da equipe.
    - Aguarde a aprovação antes de prosseguir.
    - Incentive os revisores a deixarem comentários construtivos.

5. **Merge do Pull Request**
    - Após receber a aprovação, o PR pode ser mergeado na `production`.

## Boas Práticas

- **Commits Atômicos:** Faça commits pequenos e específicos. Isso facilita a revisão de código e a identificação de bugs.
- **Mensagens de Commit Claras:** Use mensagens de commit claras e significativas, incluindo o ID da Issue do Github.
- **Revisão Construtiva:** Ao revisar um PR, forneça feedback claro e construtivo para ajudar o autor a melhorar o código, lembre-se após aprovado a responsabildiade pelo código também é do revisor.

## Regras de Proteção da Branch `main`

1. **Sem Commits Diretos:** Nenhum commit deve ser feito diretamente na `production`.
2. **Aprovação Obrigatória:** Cada PR deve ser aprovado por pelo menos um membro da equipe antes de ser mergeado.
3. **Nomeação de PRs:** Todos os PRs devem incluir o ID da Issue.

## Versionamento Semântico

Utilizamos versionamento semântico para nomear nossas versões, o que facilita a comunicação e rastreamento das mudanças no projeto.

### Versão X.Y.Z

- **X (Major):** Mudanças incompatíveis na API e na aplicação, que exigem modificações no código existente.
- **Y (Minor):** Funcionalidades adicionadas de forma compatível, que não quebram a API e a aplicação existente.
- **Z (Patch):** Correções de bugs compatíveis e melhorias menores que não afetam a compatibilidade da API e da aplicação existente.

### Exemplos de Versionamento

- `1.0.0`: Primeira versão estável.
- `1.1.0`: Adição de uma nova funcionalidade de forma compatível.
- `1.1.1`: Correção de um bug menor ou melhoria sem impacto na compatibilidade.
