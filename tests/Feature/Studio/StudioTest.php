<?php

use App\Livewire\Studio\Studio;
use App\Models\User;
use Livewire\Livewire;

test('guests are redirected when they visit Studio', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;

    $response = $this->get(route('studio'));

    $response->assertRedirect(route('login'));
});

test('team members can render Studio with the shared website model', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('studio'));

    $response
        ->assertOk()
        ->assertSee('STUDIO')
        ->assertSee('Acme Studio')
        ->assertSee('Get started')
        ->assertSee('Website navigation');

    $this->get(route('builder'))
        ->assertOk()
        ->assertSee('STUDIO');
});

test('the website model keeps page identity and generic sections separate from Studio state', function () {
    $studio = Livewire::test(Studio::class);
    $website = $studio->get('website');

    expect($website)
        ->toHaveKeys(['id', 'name', 'domain', 'theme', 'navigation', 'pages'])
        ->not->toHaveKey('activePage')
        ->not->toHaveKey('activeSection')
        ->not->toHaveKey('activePanel');

    expect($website['pages'][0]['id'])->toBe('home');
    expect($website['pages'][0]['sections'][0])->not->toHaveKey('type');
    expect($website['pages'][0]['sections'][0]['widgets'][0])->toHaveKey('type');
});

test('page section and widget actions update the website model by identity', function () {
    $studio = Livewire::test(Studio::class)
        ->set('website.pages.1.name', 'Our story')
        ->call('selectPage', 'about')
        ->assertSet('activePage', 'about')
        ->call('selectPage', 'home')
        ->call('selectSection', 'home-services')
        ->call('addWidget', 'button-group')
        ->assertSet('website.pages.0.sections.1.widgets.2.type', 'button-group')
        ->call('addPage')
        ->assertSet('website.pages.3.name', 'Page 4')
        ->assertSet('website.navigation.items.3.label', 'Page 4')
        ->call('addSection')
        ->call('addWidget', 'button-group')
        ->assertSet('website.pages.3.sections.0.widgets.0.type', 'button-group')
        ->assertSet('website.theme.name', 'Minimal Studio');

    $website = $studio->get('website');
    $newPage = $website['pages'][3];

    expect($studio->get('activePage'))->toBe($newPage['id'])
        ->and($newPage['id'])->not->toBe($newPage['name'])
        ->and($website['navigation']['items'][3]['page'])->toBe($newPage['id'])
        ->and($newPage['sections'][0])->not->toHaveKey('type');
});

test('all existing widget types can be added to and rendered from a section', function () {
    $studio = Livewire::test(Studio::class);
    $types = ['heading', 'text', 'button', 'button-group', 'image', 'card', 'table', 'form', 'gallery', 'faq'];

    foreach ($types as $index => $type) {
        $studio
            ->call('addWidget', $type)
            ->assertSet('website.pages.0.sections.0.widgets.'.(4 + $index).'.type', $type);
    }

    $studio
        ->assertSee('Frequently asked question?')
        ->assertSee('Item 1')
        ->assertDontSee('Unsupported widget type:');
});

test('editing widget content and theme updates the model and canvas', function () {
    Livewire::test(Studio::class)
        ->call('selectWidget', 'home-heading')
        ->assertSet('activeWidget', 'home-heading')
        ->set('website.pages.0.sections.0.widgets.1.content.text', 'A changed heading')
        ->call('selectTheme', 'Editorial')
        ->assertSet('website.pages.0.sections.0.widgets.1.content.text', 'A changed heading')
        ->assertSet('website.theme.name', 'Editorial')
        ->assertSet('website.theme.colors.primary', 'violet')
        ->assertSet('activeTheme', 'Editorial')
        ->assertSee('A changed heading');
});
