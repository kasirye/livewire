<?php

namespace Tests;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MoveCommandTest extends TestCase
{
    /** @test */
    public function component_is_renamed_by_move_command()
    {
        Artisan::call('make:livewire bob');

        $this->assertTrue(File::exists($this->livewireClassesPath('Bob.php')));
        $this->assertTrue(File::exists($this->livewireViewsPath('bob.blade.php')));

        Artisan::call('livewire:move bob lob');

        $this->assertTrue(File::exists($this->livewireClassesPath('Lob.php')));
        $this->assertTrue(File::exists($this->livewireViewsPath('lob.blade.php')));

        $this->assertFalse(File::exists($this->livewireClassesPath('Bob.php')));
        $this->assertFalse(File::exists($this->livewireViewsPath('bob.blade.php')));
    }

    /** @test */
    public function component_is_renamed_by_mv_command()
    {
        Artisan::call('make:livewire bob');

        $this->assertTrue(File::exists($this->livewireClassesPath('Bob.php')));
        $this->assertTrue(File::exists($this->livewireViewsPath('bob.blade.php')));

        Artisan::call('livewire:mv bob lob');

        $this->assertTrue(File::exists($this->livewireClassesPath('Lob.php')));
        $this->assertTrue(File::exists($this->livewireViewsPath('lob.blade.php')));

        $this->assertFalse(File::exists($this->livewireClassesPath('Bob.php')));
        $this->assertFalse(File::exists($this->livewireViewsPath('bob.blade.php')));
    }

    /** @test */
    public function nested_component_is_renamed_by_move_command()
    {
        Artisan::call('make:livewire bob.lob');

        $this->assertTrue(File::exists($this->livewireClassesPath('Bob/Lob.php')));
        $this->assertTrue(File::exists($this->livewireViewsPath('bob/lob.blade.php')));

        Artisan::call('livewire:move bob.lob bob.lob.law');

        $this->assertTrue(File::exists($this->livewireClassesPath('Bob/Lob/Law.php')));
        $this->assertTrue(File::exists($this->livewireViewsPath('bob/lob/law.blade.php')));

        $this->assertFalse(File::exists($this->livewireClassesPath('Bob/Lob.php')));
        $this->assertFalse(File::exists($this->livewireViewsPath('bob/lob.blade.php')));
    }

    /** @test */
    public function multiword_component_is_renamed_by_move_command()
    {
        Artisan::call('make:livewire bob-lob');

        $this->assertTrue(File::exists($this->livewireClassesPath('BobLob.php')));
        $this->assertTrue(File::exists($this->livewireViewsPath('bob-lob.blade.php')));

        Artisan::call('livewire:move bob-lob lob-law');

        $this->assertTrue(File::exists($this->livewireClassesPath('/LobLaw.php')));
        $this->assertTrue(File::exists($this->livewireViewsPath('lob-law.blade.php')));

        $this->assertFalse(File::exists($this->livewireClassesPath('BobLob.php')));
        $this->assertFalse(File::exists($this->livewireViewsPath('bob-lob.blade.php')));
    }

    /** @test */
    public function pascal_case_component_is_automatically_converted_by_move_command()
    {
        Artisan::call('make:livewire BobLob.BobLob');

        $this->assertTrue(File::exists($this->livewireClassesPath('BobLob/BobLob.php')));
        $this->assertTrue(File::exists($this->livewireViewsPath('bob-lob/bob-lob.blade.php')));

        Artisan::call('livewire:move BobLob.BobLob LobLaw.LobLaw');

        $this->assertFalse(File::exists($this->livewireClassesPath('BobLob/BobLob.php')));
        $this->assertFalse(File::exists($this->livewireViewsPath('bob-lob/bob-lob.blade.php')));

        $this->assertTrue(File::exists($this->livewireClassesPath('LobLaw/LobLaw.php')));
        $this->assertTrue(File::exists($this->livewireViewsPath('lob-law/lob-law.blade.php')));
    }
}