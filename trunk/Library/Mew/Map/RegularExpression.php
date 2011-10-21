<?php

/*
 */
class Mew_Map_RegularExpression
{
	public    static $DELIMITER           = '%';
	protected static $START               = '^';
	protected static $END                 = '$';
	public    static $PARAMETER_SEPARATOR = '/';
	public    static $PREPEND             = '/?';
	public    static $APPEND              = '(/[^?]+)?';
	public    static $QUERY_STRING        = '(\?.+)?';

	public function match( $route, $request, &$matched )
	{
		$pattern = self::$DELIMITER
		         . self::$START
		         . self::$PREPEND
		         . $route[0]
		         . self::$APPEND
		         . self::$QUERY_STRING
		         . self::$END
		         . self::$DELIMITER;

		if ( preg_match( $pattern, $request, $matches, PREG_OFFSET_CAPTURE ) )
		{
			$matched = $route[1];
			array_shift( $matches );

			foreach ( $matches as $key => $match )
			{
				if ( isset( $route[2][ $key ] ) )
				{
					$matched[ $route[2][ $key ] ] = $match[0];
				}
				else if ( $key == count( $matches ) - 1 )
				{
					$params = explode( self::$PARAMETER_SEPARATOR, substr( $match[0], 1 ) );

					for ( $i = 0; $i < count( $params ); $i++ )
					{
						if ( !( $i % 2 ) )
						{
							if ( isset( $matched[ $params[ $i ] ] ) )
							{
								$i++;
								continue;
							}

							$value = isset( $params[ $i + 1 ] ) ? $params[ $i + 1 ] : null;
							$matched[ $params[ $i ] ] = $value;
							$i++;
						}
					}

					break;
				}
				else
				{
					//throw new Exception( 'ROUTE ERROR' );
					//return false;
					break;
				}
			}

			return true;
		}

		return false;
	}
}

