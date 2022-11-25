<?php

namespace App\Spotlight;

use App\Models\Student;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightSearchResult;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightCommandDependencies;

class SearchStudents extends SpotlightCommand
{
    /**
     * This is the name of the command that will be shown in the Spotlight component.
     */
    protected string $name = 'Search Student';

    /**
     * This is the description of your command which will be shown besides the command name.
     */
    protected string $description = 'Search for students and show them';


    /**
     * Defining dependencies is optional. If you don't have any dependencies you can remove this method.
     * Dependencies are asked from your user in the order you add the dependencies.
     */
    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                // In this example we will register a 'student' dependency
                SpotlightCommandDependency::make('student')
                // The default Spotlight placeholder will be changed to your dependency place holder
                ->setPlaceholder('Which student are you looking for?')
            );
    }

    /**
     * Spotlight will resolve dependencies by calling the search method followed by your dependency name.
     * The method will receive the search query as the parameter.
     */
    public function searchStudent($query)
    {
        return Student::where('first_name', 'like', "%$query%")
        ->orWhere('last_name', 'like', "%$query%")
            ->get()
            ->map(function(Student $student) {
                // You must map your search result into SpotlightSearchResult objects
                return new SpotlightSearchResult(
                    $student->id(),
                    $student->firstName(),
                    $student->lastName(),
                    sprintf('Student for %s', $student->firstName())
                );
            });
    }

    /**
     * When all dependencies have been resolved the execute method is called.
     * You can type-hint all resolved dependency you defined earlier.
     */
    public function execute(Spotlight $spotlight, Student $student)
    {
        $spotlight->redirectRoute('student.show', $student);
    }
}