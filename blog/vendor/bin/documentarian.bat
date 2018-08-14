@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../mpociot/documentarian/documentarian
php "%BIN_TARGET%" %*
