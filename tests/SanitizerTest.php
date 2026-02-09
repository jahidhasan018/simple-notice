<?php

use PHPUnit\Framework\TestCase;

final class SanitizerTest extends TestCase {
	public function test_sanitize_select_post_all(): void {
		$this->assertSame( 'all', smn_notice_sanitize_select_post( 'all' ) );
	}

	public function test_sanitize_select_post_id(): void {
		$this->assertSame( 42, smn_notice_sanitize_select_post( '42' ) );
	}

	public function test_sanitize_hide_behavior_defaults_to_auto(): void {
		$this->assertSame( 1, smn_notice_sanitize_hide_behavior( 99 ) );
	}

	public function test_sanitize_position_defaults_when_invalid(): void {
		$this->assertSame( 'bottom center', smn_notice_sanitize_position( 'invalid' ) );
	}

	public function test_sanitize_style_defaults_when_invalid(): void {
		$this->assertSame( 'bootstrap', smn_notice_sanitize_style( 'invalid' ) );
	}

	public function test_sanitize_hide_delay_is_non_negative(): void {
		$this->assertSame( 0, smn_notice_sanitize_hide_delay( -5 ) );
	}

	public function test_sanitize_cookie_expire_is_non_negative(): void {
		$this->assertSame( 0, smn_notice_sanitize_cookie_expire( -10 ) );
	}

	public function test_sanitize_toggle_is_boolean_int(): void {
		$this->assertSame( 1, smn_notice_sanitize_toggle( 'on' ) );
		$this->assertSame( 0, smn_notice_sanitize_toggle( 0 ) );
	}

	public function test_positions_list_contains_expected_value(): void {
		$this->assertContains( 'bottom center', smn_notice_positions() );
	}

	public function test_styles_list_contains_expected_value(): void {
		$this->assertContains( 'bootstrap', smn_notice_styles() );
	}
}
