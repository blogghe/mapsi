<?php

namespace Tests\Feature;

use App\Problem;
use App\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProblemsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */

    protected function setUp()
    : void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Event::fake();
    }

    public function testBasicTest()
    {
        $response = $this->get( '/' );

        $response->assertStatus( 200 );
    }

    /** @test */
    public function only_logged_in_users_can_see_their_problems_list()
    {
        $response = $this->get( '/problems' )->assertRedirect( '/login' );
    }

    /** @test */
    public function authenticated_users_can_see_their_problem_list()
    {
        $this->actingAs( factory( User::class )->create() );
        $response = $this->get( '/problems' )
            ->assertOk();

    }

    /** @test */
    public function a_problem_can_be_added_through_a_form()
    {
        //enable better exceptions
        //$this->withoutExceptionHandling();

        //don't trigger events -> do it in over ride method
        //Event::fake();
        //admin@admin.be door ProblemPolicy
        $this->actingAsAdmin();

        $response = $this->post( '/problems', $this->data() );
        $this->assertCount( 1, Problem::all() );
    }

    /** @test */
    public function a_title_is_required()
    {
        $this->actingAsAdmin();

        $response = $this->post( '/problems', array_merge( $this->data(), [ 'title' => '' ] ) );
        $response->assertSessionHasErrors( 'title' );
        $this->assertCount( 0, Problem::all() );

    }

    /** @test */
    public function a_title_is_at_least_3_chars()
    {
        $this->actingAsAdmin();

        $response = $this->post( '/problems', array_merge( $this->data(), [ 'title' => 'a' ] ) );
        $response->assertSessionHasErrors( 'title' );
        $this->assertCount( 0, Problem::all() );

    }

    /** @test */
    public function a_status_is_required()
    {
        $this->actingAsAdmin();

        $response = $this->post( '/problems', array_merge( $this->data(), [ 'status' => '' ] ) );
        $response->assertSessionHasErrors( 'status' );
        $this->assertCount( 0, Problem::all() );

    }

    /** @test */
    public function a_description_is_required()
    {
        $this->actingAsAdmin();

        $response = $this->post( '/problems', array_merge( $this->data(), [ 'description' => '' ] ) );
        $response->assertSessionHasErrors( 'description' );
        $this->assertCount( 0, Problem::all() );

    }

    /** @test */
    public function a_service_id_is_required()
    {
        $this->actingAsAdmin();

        $response = $this->post( '/problems', array_merge( $this->data(), [ 'service_id' => '' ] ) );
        $response->assertSessionHasErrors( 'service_id' );
        $this->assertCount( 0, Problem::all() );

    }

    private function actingAsAdmin()
    {
        $this->actingAs( factory( User::class )->create( [
            'email' => 'admin@admin.com',
        ] ) );
    }

    private function data()
    {
        return [
            'title'       => 'test problem',
            'status'      => 0,
            'description' => 'big problem man',
            'service_id'  => 1,
        ];
    }

}
