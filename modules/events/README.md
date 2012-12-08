Использование модуля:

$event = new Event(Events::ON_SITE_INSTANCED_AFTER, $sender);
$event->addHandler($handler1);
$event->addHandler($handler2);
$event->addHandler($handler3);

EventManager::run($event->getName());
OR
EventManager::run(Events::ON_SITE_INSTANCED_AFTER);