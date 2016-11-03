<?php
/**
 * Extends the native PDF parser to expose some properties needed by the Link parser we're using, as it was written
 * for an older version of FPDI.
 */

require_once('pdf_parser.php');

if (!defined ('PDF_TYPE_NULL'))
	define ('PDF_TYPE_NULL', 0);
if (!defined ('PDF_TYPE_NUMERIC'))
	define ('PDF_TYPE_NUMERIC', 1);
if (!defined ('PDF_TYPE_TOKEN'))
	define ('PDF_TYPE_TOKEN', 2);
if (!defined ('PDF_TYPE_HEX'))
	define ('PDF_TYPE_HEX', 3);
if (!defined ('PDF_TYPE_STRING'))
	define ('PDF_TYPE_STRING', 4);
if (!defined ('PDF_TYPE_DICTIONARY'))
	define ('PDF_TYPE_DICTIONARY', 5);
if (!defined ('PDF_TYPE_ARRAY'))
	define ('PDF_TYPE_ARRAY', 6);
if (!defined ('PDF_TYPE_OBJDEC'))
	define ('PDF_TYPE_OBJDEC', 7);
if (!defined ('PDF_TYPE_OBJREF'))
	define ('PDF_TYPE_OBJREF', 8);
if (!defined ('PDF_TYPE_OBJECT'))
	define ('PDF_TYPE_OBJECT', 9);
if (!defined ('PDF_TYPE_STREAM'))
	define ('PDF_TYPE_STREAM', 10);
if (!defined ('PDF_TYPE_BOOLEAN'))
	define ('PDF_TYPE_BOOLEAN', 11);
if (!defined ('PDF_TYPE_REAL'))
	define ('PDF_TYPE_REAL', 12);

/**
* Class fpdi_pdf_parser_humaan
*/
class fpdi_pdf_parser_humaan extends fpdi_pdf_parser {

	public function getPages() {

		return $this->_pages;
	}

	public function getC() {

		return $this->_c;
	}
}
