1. Str::Plural de laravel sur les generations de migrations 

2. Manipulation de contenu du contrôleur fragile ControllerGenerator modifie le PHP généré par des str_replace et preg_replace sur des patterns supposés stables. Si Laravel change le format de son stub (et il l'a fait entre les versions), les remplacements silencieux échouent sans lever d'erreur. Les méthodes getServiceMethods() et getDirectMethods() sont définies mais jamais appelées (dead code). 

3. L'option --full est ignorée La signature déclare {--full} et $full = $this->option('full') est stocké, mais cette variable n'est jamais utilisée dans la logique. Le comportement est identique avec ou sans le flag.   

4. Le str_replace dans RequestGenerator::addValidationRules() cherche le commentaire // Add validation rules here tel qu'il est dans le stub — mais le stub de make:request de Laravel ne contient pas ce texte exact (il varie selon les versions). Le remplacement échouera silencieusement et les règles ne seront pas injectées. 

5. Le namespace généré est App\Http\Controllers\Api\V1 (avec Api en minuscules) mais le chemin physique est Http/Controllers/API/V1/ (majuscules). Sur Linux (case-sensitive) l'autoload PSR-4 échouera. (utilisez Api ou model adapté a linux) 