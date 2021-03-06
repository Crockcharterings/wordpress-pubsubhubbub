<?php
class FunctionsTest extends WP_UnitTestCase {
	public function test_pubsubhubbub_get_topic_urls() {
		$urls = pubsubhubbub_get_topic_urls();

		$result = array(
			'http://example.org/?feed=atom',
			'http://example.org/?feed=rdf',
			'http://example.org/?feed=rss2',
			'http://example.org/?feed=comments-atom',
			'http://example.org/?feed=comments-rss2',
		);

		$this->assertEquals( $result, $urls );
	}

	public function test_pubsubhubbub_get_topic_urls2() {
		pubsubhubbub_update_topic_urls( array( 'http://example.org/?feed=json' ) );

		$urls = pubsubhubbub_get_topic_urls();

		$result = array(
			'http://example.org/?feed=atom',
			'http://example.org/?feed=rdf',
			'http://example.org/?feed=rss2',
			'http://example.org/?feed=comments-atom',
			'http://example.org/?feed=comments-rss2',
			'http://example.org/?feed=json',
		);

		$this->assertEquals( $result, $urls );
	}

	public function test_pubsubhubbub_get_self_link() {
		$url = pubsubhubbub_get_self_link();

		$this->assertFalse( $url );
	}

	public function test_pubsubhubbub_get_self_link2() {
		add_filter(
			'home_url',
			function( $url ) {
				if ( 'http://example.org' == $url ) {
					return 'http://example.org/?feed=atom';
				}

				return $url;
			}
		);

		$url = pubsubhubbub_get_self_link();

		$this->assertEquals( 'http://example.org/?feed=atom', $url );
	}

	public function test_pubsubhubbub_get_self_link3() {
		add_filter(
			'home_url',
			function( $url ) {
				if ( 'http://example.org' == $url ) {
					return 'https://example.org/?feed=atom';
				}

				return $url;
			}
		);

		$url = pubsubhubbub_get_self_link();

		$this->assertEquals( 'http://example.org/?feed=atom', $url );
	}

	public function test_pubsubhubbub_show_discovery() {
		$bool = pubsubhubbub_show_discovery();

		$this->assertFalse( $bool );
	}

	public function test_pubsubhubbub_show_discovery2() {
		add_filter(
			'home_url',
			function( $url ) {
				if ( 'http://example.org' == $url ) {
					return 'http://example.org/?feed=atom';
				}

				return $url;
			}
		);

		$bool = pubsubhubbub_show_discovery();

		$this->assertTrue( $bool );
	}
}
