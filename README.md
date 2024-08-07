![Logo do VisiteMuseus](/assets/images/logo-horizontal.svg)

# CNE - Tema para o projeto VisiteMuseus

## Descrição

Este repositório contém o código do tema WordPress usado no site **[VisiteMuseus](https://visite.museus.gov.br), uma Plataforma de promoção dos museus brasileiros**. O tema em si tem como slug e nome de pasta `cne`, sigla do antigo nome *Cadastro Nacional de Eventos*.

Para além das funcionalidades geralmente encontradas em temas (folhas de estilo, customizações de bloco), este projeto contém diversas implementações específicas para o projeto. O sistema adapta as coleções do Tainacan para serem usadas em cenário de instituições e eventos recorrentes. Há também restrições e adaptações da interface e do fluxo de navegação para os usuários Gestores de Eventos. Por fim, uma funcionalidade especial permite a importação de dados de instituições a partir do Cadastro Nacional de Museus ([MuseusBR](https://cadastro.museus.gov.br)).

## Table of Contents

- [CNE - Tema para o projeto VisiteMuseus](#cne---tema-para-o-projeto-visitemuseus)
  - [Descrição](#descrição)
  - [Table of Contents](#table-of-contents)
    - [Dependências](#dependências)
  - [Instalação](#instalação)
  - [Configuração](#configuração)
  - [Documentação](#documentação)
  - [Compilação](#compilação)
  - [Licença](#licença)

### Dependências

O projeto tem dependências fortes necessárias para seu funcionamento adequado, que são listadas a seguir:
- Tema pai [Blocksy](https://wordpress.org/themes/blocksy/);
- Plugin [Tainacan](https://wordpress.org/plugins/tainacan/);
- Plugin de [Integração do Tainacan ao Blocksy](https://wordpress.org/plugins/tainacan-blocksy/);
- Plugin de [Registro de Usuários](https://wordpress.org/plugins/user-registration/);
- Plugin de Customização do Admin [Branda](https://wordpress.org/plugins/branda-white-labeling);
- Plugin de [Bloco de Carrossel](https://wordpress.org/plugins/carousel-block) utilizado na página inicial;
- Plugin de [Customização de funções de usuários](https://wordpress.org/plugins/plugin-information&plugin=user-role-editor);

No site, outros plugins podem ser utilizados para funcionalidades extras como desempenho, SEO, email, etc.

## Instalação

1. Instale o tema pai no painel administrativo do WordPress em *"Aparência" -> "Temas" -> "Pesquisar" -> Blocksy"*;
2. Instale e ative os plugins necessários no painel administrativo do WordPress em *"Plugins" -> "Pesquisar"*;
3. Crie um .zip com o conteúdo deste repositório, chamando-o de `cne`. A depender da sua instalação, alguns arquivos podem ser ignorados para o envio:
   - A pasta [/museusbr-fetcher/node_modules](/museusbr-fetcher/), caso tenha sido compilado, visto que os arquivos fonte não são necessários;
   - A pasta [/config](/config/), visto que seu conteúdo será carregado no banco na configuração;
   - A pasta *.git*, caso exista em seu repositório conteúdo do Git;
4. Envie o .zip em *"Aparência" -> "Temas" -> "Enviar novo tema*". Opcionalmente, mova a pasta `cne` para `/wp-content/themes`;
5. Ative o tema;

## Configuração

As configurações são em sua maioria guardadas em banco, portanto a maneira mais segura de chegar ao estado atual do site é através de um backup. Neste repositório porém também guardamos a cópia de alguns arquivos de configuração exportados no dia do lançamento do site:
1. Configure o tema filho recém ativado através do menu *"Aparência" -> "Personalizar" -> "Geral" -> "Gerenciar opções" -> "Importar personalizações"*. Envie e importe o [arquivo `.dat`](/config/visite-museus.gov.br-export.dat) disponível na pasta [/config](/config/);
2. Configure o plugin de registro de usuários através do menu *"User Registration" -> "Settings" -> "Import/Export" -> "Import/Export forms"*. Envie e importe o [arquivo `.json`](/config/formulário-de-registro-2024-08-07_09_33_16.json) disponível na basta [/config](/config/);
3. Configure o plugin de customização do Admin através do menu *"Branda" -> "Settings" -> "Import"*. Envie e importe o [arquivo `.json`](/config/visitemuseus.branda.2024-08-07.1723033930.json) disponível na basta [/config](/config/);

Outras configurações já feitas mas que não possuem modo de exportação envolvem o **Perfil de Usuário Gestor de Eventos**, criado através do menu *"Tainacan" -> "Funções de Usuários"* e as próprias coleções do Tainacan.

## Documentação

Para uma explicação técnica sobre as funcionalidades implementadas neste projeto, acesse nossa [Documentação](https://github.com/tainacan/cne/wiki).

## Compilação

Caso sejam feitas alterações na funcionalidade de importação de Instituições do MuseusBR, será necessário compilar novamente o código presente na pasta `/museusbr-fetcher`. O requisito mínimo é o `node v.19.1.0`, com `npm v8.19.3`:
```
cd /museusbr-fetcher
npm install
npm run build
```
Lembre-se que isto criará uma pasta `node_modules` no seu código que não precisa ser enviada para a instalação final.


## Licença

O tema CNE é software livre e está protegido pela licença **GPLv3**. Contribuições para o código obedecerão à mesma licença.
