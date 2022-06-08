# ========
# Services
# ========

# enable LDAP service (set to `True` if `PERSISTENCE_TYPE` is set to `ldap`)
SVC_LDAP = True

# enable oxAuth service
SVC_OXAUTH = True

# enable oxTrust service
SVC_OXTRUST = True

# enable Passport service
SVC_OXPASSPORT = False

# enable Shibboleth service
SVC_OXSHIBBOLETH = False

# enable CacheRefresh rotation service
SVC_CR_ROTATE = False

# enable oxd service
SVC_OXD_SERVER = True

# enable Vault service with auto-unseal
SVC_VAULT_AUTOUNSEAL = False

# enable Casa service
SVC_CASA = False

# enable Jackrabbit service (set to `True` if `DOCUMENT_STORE_TYPE` is set to `JCA`)
SVC_JACKRABBIT = False

# enable SCIM service
SVC_SCIM = True

# enable Fido2 service
SVC_FIDO2 = False

# enable persistence loader service
JOB_PERSISTENCE = True

# enable config-init service
JOB_CONFIGURATION = True

# enable Redis service (set to `True` if `CACHE_TYPE` is set to `REDIS`)
SVC_REDIS = False

# =====
# Cache
# =====

# supported cache type (choose `NATIVE_PERSISTENCE` or `REDIS`)
CACHE_TYPE = "NATIVE_PERSISTENCE"

# ===========
# Persistence
# ===========

# supported persistence type (choose one of `ldap`, `couchbase`, `hybrid`, `sql`, or `spanner`)
PERSISTENCE_TYPE = "ldap"

# dataset saved into LDAP (choose one of `default`, `user`, `site`, `token`, `cache`, or `session`)
# this setting only affects hybrid `PERSISTENCE_TYPE`
PERSISTENCE_LDAP_MAPPING = "default"

# Couchbase username
COUCHBASE_USER = "admin"

# Couchbase superuser
COUCHBASE_SUPERUSER = ""

# hostname/IP address of Couchbase server (scheme and port are omitted)
COUCHBASE_URL = "localhost"

# Prefix of Couchbase bucket
COUCHBASE_BUCKET_PREFIX = "gluu"

# SQL dialect (currently only support mysql; postgresql support is experimental)
SQL_DB_DIALECT= "mysql"

# SQL database name
SQL_DB_NAME = "gluu"

# hostname/IP address of SQL server
SQL_DB_HOST = "localhost"

# port of SQL server
SQL_DB_PORT = 3306

# username to access SQL database
SQL_DB_USER = "gluu"

# Google project ID
GOOGLE_PROJECT_ID = ""

# Instance ID of Google Spanner
GOOGLE_SPANNER_INSTANCE_ID = ""

# Database ID of Google Spanner
GOOGLE_SPANNER_DATABASE_ID = ""

# Host of Spanner emulator, i.e. 10.10.1.2:9010
SPANNER_EMULATOR_HOST = ""

# ==============
# Document store
# ==============

# supported store type (choose one of `LOCAL` or `JCA`)
DOCUMENT_STORE_TYPE = "LOCAL"

# admin username for Jackrabbit service
JACKRABBIT_USER = "admin"

# ====
# Misc
# ====

# load customization from docker-compose.override.yml (if exists)
ENABLE_OVERRIDE = False

# enable oxTrust API
OXTRUST_API_ENABLED = False

# enable test-mode for oxTrust API
OXTRUST_API_TEST_MODE = False

# enable Passport support
PASSPORT_ENABLED = False

# enable Casa support
CASA_ENABLED = False

# enable SAML Shibboleth support
SAML_ENABLED = False

# enable SCIM API
SCIM_ENABLED = False

# enable test-mode for SCIM API (default to `OAUTH`)
GLUU_SCIM_PROTECTION_MODE = "TEST"
