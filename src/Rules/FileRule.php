<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ AbstractRule, Invalidity };

final class FileRule extends AbstractRule {

	const RULE_NAME = 'file';

	const MIME_TYPES = [
		'application/java'
			=> [ 'class' ],
		'application/javascript'
			=> [ 'js' ],
		'application/msword'
			=> [ 'doc' ],
		'application/octet-stream'
			=> [ 'psd', 'xcf' ],
		'application/onenote'
			=> [ 'onetoc', 'onetoc2', 'onetmp', 'onepkg' ],
		'application/oxps'
			=> [ 'oxps' ],
		'application/pdf'
			=> [ 'pdf' ],
		'application/rar'
			=> [ 'rar' ],
		'application/rtf'
			=> [ 'rtf' ],
		'application/ttaf+xml'
			=> [ 'dfxp' ],
		'application/vnd.apple.keynote'
			=> [ 'key' ],
		'application/vnd.apple.numbers'
			=> [ 'numbers' ],
		'application/vnd.apple.pages'
			=> [ 'pages' ],
		'application/vnd.ms-access'
			=> [ 'mdb' ],
		'application/vnd.ms-excel'
			=> [ 'xla', 'xls', 'xlt', 'xlw' ],
		'application/vnd.ms-excel.addin.macroEnabled.12'
			=> [ 'xlam' ],
		'application/vnd.ms-excel.sheet.binary.macroEnabled.12'
			=> [ 'xlsb' ],
		'application/vnd.ms-excel.sheet.macroEnabled.12'
			=> [ 'xlsm' ],
		'application/vnd.ms-excel.template.macroEnabled.12'
			=> [ 'xltm' ],
		'application/vnd.ms-powerpoint'
			=> [ 'pot', 'pps', 'ppt' ],
		'application/vnd.ms-powerpoint.addin.macroEnabled.12'
			=> [ 'ppam' ],
		'application/vnd.ms-powerpoint.presentation.macroEnabled.12'
			=> [ 'pptm' ],
		'application/vnd.ms-powerpoint.slide.macroEnabled.12'
			=> [ 'sldm' ],
		'application/vnd.ms-powerpoint.slideshow.macroEnabled.12'
			=> [ 'ppsm' ],
		'application/vnd.ms-powerpoint.template.macroEnabled.12'
			=> [ 'potm' ],
		'application/vnd.ms-project'
			=> [ 'mpp' ],
		'application/vnd.ms-word.document.macroEnabled.12'
			=> [ 'docm' ],
		'application/vnd.ms-word.template.macroEnabled.12'
			=> [ 'dotm' ],
		'application/vnd.ms-write'
			=> [ 'wri' ],
		'application/vnd.ms-xpsdocument'
			=> [ 'xps' ],
		'application/vnd.oasis.opendocument.chart'
			=> [ 'odc' ],
		'application/vnd.oasis.opendocument.database'
			=> [ 'odb' ],
		'application/vnd.oasis.opendocument.formula'
			=> [ 'odf' ],
		'application/vnd.oasis.opendocument.graphics'
			=> [ 'odg' ],
		'application/vnd.oasis.opendocument.presentation'
			=> [ 'odp' ],
		'application/vnd.oasis.opendocument.spreadsheet'
			=> [ 'ods' ],
		'application/vnd.oasis.opendocument.text'
			=> [ 'odt' ],
		'application/vnd.openxmlformats-officedocument.presentationml.presentation'
			=> [ 'pptx' ],
		'application/vnd.openxmlformats-officedocument.presentationml.slide'
			=> [ 'sldx' ],
		'application/vnd.openxmlformats-officedocument.presentationml.slideshow'
			=> [ 'ppsx' ],
		'application/vnd.openxmlformats-officedocument.presentationml.template'
			=> [ 'potx' ],
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
			=> [ 'xlsx' ],
		'application/vnd.openxmlformats-officedocument.spreadsheetml.template'
			=> [ 'xltx' ],
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
			=> [ 'docx' ],
		'application/vnd.openxmlformats-officedocument.wordprocessingml.template'
			=> [ 'dotx' ],
		'application/wordperfect'
			=> [ 'wp', 'wpd' ],
		'application/x-7z-compressed'
			=> [ '7z' ],
		'application/x-gzip'
			=> [ 'gz', 'gzip' ],
		'application/x-msdownload'
			=> [ 'exe' ],
		'application/x-shockwave-flash'
			=> [ 'swf' ],
		'application/x-tar'
			=> [ 'tar' ],
		'application/zip'
			=> [ 'zip' ],
		'audio/aac'
			=> [ 'aac' ],
		'audio/flac'
			=> [ 'flac' ],
		'audio/midi'
			=> [ 'mid', 'midi' ],
		'audio/mpeg'
			=> [ 'mp3', 'm4a', 'm4b' ],
		'audio/ogg'
			=> [ 'ogg', 'oga' ],
		'audio/wav'
			=> [ 'wav', 'x-wav' ],
		'audio/x-matroska'
			=> [ 'mka' ],
		'audio/x-ms-wax'
			=> [ 'wax' ],
		'audio/x-ms-wma'
			=> [ 'wma' ],
		'audio/x-realaudio'
			=> [ 'ra', 'ram' ],
		'image/avif'
			=> [ 'avif' ],
		'image/bmp'
			=> [ 'bmp' ],
		'image/gif'
			=> [ 'gif' ],
		'image/heic'
			=> [ 'heic' ],
		'image/heic-sequence'
			=> [ 'heics' ],
		'image/heif'
			=> [ 'heif' ],
		'image/heif-sequence'
			=> [ 'heifs' ],
		'image/jpeg'
			=> [ 'jpg', 'jpeg', 'jpe' ],
		'image/png'
			=> [ 'png' ],
		'image/tiff'
			=> [ 'tiff', 'tif' ],
		'image/webp'
			=> [ 'webp' ],
		'image/x-icon'
			=> [ 'ico' ],
		'text/calendar'
			=> [ 'ics' ],
		'text/css'
			=> [ 'css' ],
		'text/csv'
			=> [ 'csv' ],
		'text/html'
			=> [ 'htm', 'html' ],
		'text/plain'
			=> [ 'txt', 'asc', 'c', 'cc', 'h', 'srt' ],
		'text/richtext'
			=> [ 'rtx' ],
		'text/tab-separated-values'
			=> [ 'tsv' ],
		'text/vtt'
			=> [ 'vtt' ],
		'video/3gpp'
			=> [ '3gp', '3gpp' ],
		'video/3gpp2'
			=> [ '3g2', '3gp2' ],
		'video/avi'
			=> [ 'avi' ],
		'video/divx'
			=> [ 'divx' ],
		'video/mp4'
			=> [ 'mp4', 'm4v' ],
		'video/mpeg'
			=> [ 'mpeg', 'mpg', 'mpe' ],
		'video/ogg'
			=> [ 'ogv' ],
		'video/quicktime'
			=> [ 'mov', 'qt' ],
		'video/webm'
			=> [ 'webm' ],
		'video/x-flv'
			=> [ 'flv' ],
		'video/x-matroska'
			=> [ 'mkv' ],
		'video/x-ms-asf'
			=> [ 'asf', 'asx' ],
		'video/x-ms-wm'
			=> [ 'wm' ],
		'video/x-ms-wmv'
			=> [ 'wmv' ],
		'video/x-ms-wmx'
			=> [ 'wmx' ],
	];


	public string $field;
	public string $error;
	public array $accept;


	/**
	 * Constructor.
	 *
	 * @param iterable $properties Rule properties.
	 */
	public function __construct( iterable $properties = [] ) {
		$this->field = $properties[ 'field' ] ?? '';
		$this->error = $properties[ 'error' ] ?? '';
		$this->accept = $properties[ 'accept' ] ?? [];
	}


	/**
	 * Retrieves the list of mime types and file extensions.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_get_mime_types/
	 *
	 * @return array Array of mime types keyed by the file extension regex
	 *               corresponding to those types.
	 */
	public static function getMimeTypes(): array {
		return [
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif' => 'image/gif',
			'png' => 'image/png',
			'bmp' => 'image/bmp',
			'tiff|tif' => 'image/tiff',
			'webp' => 'image/webp',
			'avif' => 'image/avif',
			'ico' => 'image/x-icon',
			'heic' => 'image/heic',
			'heif' => 'image/heif',
			'heics' => 'image/heic-sequence',
			'heifs' => 'image/heif-sequence',
			'asf|asx' => 'video/x-ms-asf',
			'wmv' => 'video/x-ms-wmv',
			'wmx' => 'video/x-ms-wmx',
			'wm' => 'video/x-ms-wm',
			'avi' => 'video/avi',
			'divx' => 'video/divx',
			'flv' => 'video/x-flv',
			'mov|qt' => 'video/quicktime',
			'mpeg|mpg|mpe' => 'video/mpeg',
			'mp4|m4v' => 'video/mp4',
			'ogv' => 'video/ogg',
			'webm' => 'video/webm',
			'mkv' => 'video/x-matroska',
			'3gp|3gpp' => 'video/3gpp',
			'3g2|3gp2' => 'video/3gpp2',
			'txt|asc|c|cc|h|srt' => 'text/plain',
			'csv' => 'text/csv',
			'tsv' => 'text/tab-separated-values',
			'ics' => 'text/calendar',
			'rtx' => 'text/richtext',
			'css' => 'text/css',
			'htm|html' => 'text/html',
			'vtt' => 'text/vtt',
			'dfxp' => 'application/ttaf+xml',
			'mp3|m4a|m4b' => 'audio/mpeg',
			'aac' => 'audio/aac',
			'ra|ram' => 'audio/x-realaudio',
			'wav|x-wav' => 'audio/wav',
			'ogg|oga' => 'audio/ogg',
			'flac' => 'audio/flac',
			'mid|midi' => 'audio/midi',
			'wma' => 'audio/x-ms-wma',
			'wax' => 'audio/x-ms-wax',
			'mka' => 'audio/x-matroska',
			'rtf' => 'application/rtf',
			'js' => 'application/javascript',
			'pdf' => 'application/pdf',
			'swf' => 'application/x-shockwave-flash',
			'class' => 'application/java',
			'tar' => 'application/x-tar',
			'zip' => 'application/zip',
			'gz|gzip' => 'application/x-gzip',
			'rar' => 'application/rar',
			'7z' => 'application/x-7z-compressed',
			'exe' => 'application/x-msdownload',
			'psd' => 'application/octet-stream',
			'xcf' => 'application/octet-stream',
			'doc' => 'application/msword',
			'pot|pps|ppt' => 'application/vnd.ms-powerpoint',
			'wri' => 'application/vnd.ms-write',
			'xla|xls|xlt|xlw' => 'application/vnd.ms-excel',
			'mdb' => 'application/vnd.ms-access',
			'mpp' => 'application/vnd.ms-project',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
			'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
			'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
			'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
			'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
			'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
			'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
			'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
			'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
			'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
			'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
			'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
			'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
			'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
			'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
			'sldm' => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
			'onetoc|onetoc2|onetmp|onepkg' => 'application/onenote',
			'oxps' => 'application/oxps',
			'xps' => 'application/vnd.ms-xpsdocument',
			'odt' => 'application/vnd.oasis.opendocument.text',
			'odp' => 'application/vnd.oasis.opendocument.presentation',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			'odg' => 'application/vnd.oasis.opendocument.graphics',
			'odc' => 'application/vnd.oasis.opendocument.chart',
			'odb' => 'application/vnd.oasis.opendocument.database',
			'odf' => 'application/vnd.oasis.opendocument.formula',
			'wp|wpd' => 'application/wordperfect',
			'key' => 'application/vnd.apple.keynote',
			'numbers' => 'application/vnd.apple.numbers',
			'pages' => 'application/vnd.apple.pages',
		];
	}


	/**
	 * Converts a MIME type string to an array of corresponding file extensions.
	 *
	 * @param string $mime MIME type. Wildcard (*) is available for the subtype.
	 * @return array Corresponding file extensions.
	 */
	public static function convertMimeToExt( string $mime ): array {
		$results = array();

		if ( preg_match( '%^([a-z]+)/([*]|[a-z0-9.+-]+)$%i', $mime, $matches ) ) {
			foreach ( self::getMimeTypes() as $extensions => $mime_type ) {
				if (
					$mime_type === $matches[ 0 ] or
					0 === strpos( $mime_type, $matches[ 1 ] . '/' ) and
					'*' === $matches[ 2 ]
				) {
					$results = array_merge( $results, explode( '|', $extensions ) );
				}
			}
		}

		return array_values( array_unique( $results ) );
	}


	/**
	 * Returns true if this rule matches the given context.
	 *
	 * @param iterable $context Context.
	 */
	public function matches( iterable $context ): bool {
		if ( false === parent::matches( $context ) ) {
			return false;
		}

		if ( empty( $context[ 'file' ] ) ) {
			return false;
		}

		return true;
	}


	/**
	 * Validates the form data according to the logic defined by this rule.
	 *
	 * @param FormDataInterface $form_data Form data.
	 * @param iterable $context Context.
	 */
	public function validate( FormDataInterface $form_data, iterable $context ) {
		$files = $form_data->getAllFiles( $this->field );

		$acceptable_filetypes = array();

		foreach ( $this->accept as $accept ) {
			if ( preg_match( '/^\.[a-z0-9]+$/i', $accept ) ) {
				$acceptable_filetypes[] = $accept;
			} else {
				foreach ( self::convertMimeToExt( $accept ) as $extension ) {
					$acceptable_filetypes[] = sprintf( '.%s', trim( $extension, ' .' ) );
				}
			}
		}

		$acceptable_filetypes = array_map( 'strtolower', $acceptable_filetypes );
		$acceptable_filetypes = array_unique( $acceptable_filetypes );

		foreach ( $files as $file ) {
			$file_name = $file->name();

			$last_period_pos = strrpos( $file_name, '.' );

			if ( false === $last_period_pos ) { // No period.
				throw new Invalidity( $this );
			}

			$suffix = strtolower( substr( $file_name, $last_period_pos ) );

			if ( ! in_array( $suffix, $acceptable_filetypes, true ) ) {
				throw new Invalidity( $this );
			}
		}

		return true;
	}

}
