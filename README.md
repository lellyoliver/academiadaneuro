# Gitflow para ACADEMIA DA NEUROCIENCIA

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
    git pull origin production
    git checkout -b feature/nome-da-feature
    ```

2. **Implementar as Mudanças**
    - Faça commits frequentes e atômicos. Cada commit deve ter uma única responsabilidade clara.
    - Exemplo de commit:

    ```sh
    git add .
    git commit -m "8: Implementa melhoria de performance na API"
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
