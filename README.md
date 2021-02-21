# EXT:oidc_server

OpenID Connect server for TYPO3.

## Installation

**Only composer supported!**

```bash
$ composer require r3h6/oidc-server
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

## Integration
```yaml
imports:
    - { resource: 'EXT:oidc_server/Configuration/Site/Config.yaml' }
```

## Hooks

Location
: R3H6\OidcServer\Domain\Model\User::getClaims

Register
: $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['oidc_server']['domain/model/user/modify-claims']

Interface
: R3H6\OidcServer\Domain\Model\UserGetClaimsHookInterface
