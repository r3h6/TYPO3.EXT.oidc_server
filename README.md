# EXT:oidc_server

```yaml
oauth2:
  server: R3H6\OidcServer\Http\OidcServer

  routes:
    'GET:oauth/authorize': 'R3H6\OidcServer\Controller\AuthorizationController::startAuthorization'
    'POST:oauth/authorize': 'R3H6\OidcServer\Controller\AuthorizationController::approveAuthorization'
    'DELETE:oauth/authorize': 'R3H6\OidcServer\Controller\AuthorizationController::denyAuthorization'
    'POST:oauth/token': 'R3H6\OidcServer\Controller\TokenController::issueAccessToken'
    'GET:oauth/userinfo': 'R3H6\OidcServer\Controller\UserinfoController::getClaims'
```
