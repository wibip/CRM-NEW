<?php 
class ZipArchive implements Countable {
/* Properties */
int $status;
int $statusSys;
int $numFiles;
string $filename;
string $comment;
/* Methods */
addEmptyDir ( string $dirname ) : bool
addFile ( string $filename [, string $localname = NULL [, int $start = 0 [, int $length = 0 ]]] ) : bool
addFromString ( string $localname , string $contents ) : bool
addGlob ( string $pattern [, int $flags = 0 [, array $options = array() ]] ) : bool
addPattern ( string $pattern [, string $path = "." [, array $options = array() ]] ) : bool
close ( void ) : bool
public count ( void ) : int
deleteIndex ( int $index ) : bool
deleteName ( string $name ) : bool
extractTo ( string $destination [, mixed $entries ] ) : bool
getArchiveComment ([ int $flags ] ) : string
getCommentIndex ( int $index [, int $flags ] ) : string
getCommentName ( string $name [, int $flags ] ) : string
GetExternalAttributesIndex ( int $index , int &$opsys , int &$attr [, int $flags ] ) : bool
getExternalAttributesName ( string $name , int &$opsys , int &$attr [, int $flags ] ) : bool
getFromIndex ( int $index [, int $length = 0 [, int $flags ]] ) : string
getFromName ( string $name [, int $length = 0 [, int $flags ]] ) : string
getNameIndex ( int $index [, int $flags ] ) : string
getStatusString ( void ) : string
getStream ( string $name ) : resource
locateName ( string $name [, int $flags ] ) : int
open ( string $filename [, int $flags ] ) : mixed
renameIndex ( int $index , string $newname ) : bool
renameName ( string $name , string $newname ) : bool
setArchiveComment ( string $comment ) : bool
setCommentIndex ( int $index , string $comment ) : bool
setCommentName ( string $name , string $comment ) : bool
setCompressionIndex ( int $index , int $comp_method [, int $comp_flags = 0 ] ) : bool
setCompressionName ( string $name , int $comp_method [, int $comp_flags = 0 ] ) : bool
setEncryptionIndex ( int $index , string $method [, string $password ] ) : bool
setEncryptionName ( string $name , int $method [, string $password ] ) : bool
setExternalAttributesIndex ( int $index , int $opsys , int $attr [, int $flags ] ) : bool
setExternalAttributesName ( string $name , int $opsys , int $attr [, int $flags ] ) : bool
public setPassword ( string $password ) : bool
statIndex ( int $index [, int $flags ] ) : array
statName ( string $name [, int $flags ] ) : array
unchangeAll ( void ) : bool
unchangeArchive ( void ) : bool
unchangeIndex ( int $index ) : bool
unchangeName ( string $name ) : bool
}


?>