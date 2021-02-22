# EXT:oidc_server

OpenID Connect server for TYPO3 based on [OAuth 2.0 OpenID Connect Server](https://github.com/steverhoades/oauth2-openid-connect-server).


## Installation

**Only composer supported!**

```bash
$ composer require r3h6/oidc-server
```


## Integration

Import in your site configuration:
```yaml
imports:
  - { resource: "EXT:oidc_server/Configuration/Site/Config.yaml" }
```


## Configuration

```yaml

oauth2:
  # Enable oidc support
  oidc: true

  # Define custom claim sets
  claimSets:
    # Scope
    role:
      # Claims (see hooks)
      - Roles

```


## Hooks

Location
: R3H6\OidcServer\Domain\Model\User::getClaims

Register
: $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['oidc_server']['domain/model/user/modify-claims']

Interface
: R3H6\OidcServer\Domain\Model\UserGetClaimsHookInterface
