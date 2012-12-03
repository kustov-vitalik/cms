<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
return arraY(

    /**
     * Путь к папке со словарями
     */
    'dir' => MODPATH . 'search/vendor/phpmorphy-0.3.7/dicts',

    /**
     *  Язык
     */
    'lang'          => 'ru_RU',
    'options'       => array(
        /**
         *  Указывает способ обращения к файлам словаря.
         * Для PHPMORPHY_STORAGE_SHM требуется наличие расширения shmop.
         *
         * Значение по умолчанию: PHPMORPHY_STORAGE_FILE
         *
         * Допустимые значения:
         *
         *          PHPMORPHY_STORAGE_FILE - использует файловые операции.
         *      Потребляется небольшое количество памяти.
         * Самый медленный способ, однако, работает в любом окружении
         *
         *          PHPMORPHY_STORAGE_MEM - загружает словари в память.
         *  Плюсы этого способа в том, что обеспечивается самый быстрый
         * способ доступа и работа в любом окружении. Однако имеется один
         * существенный минус – словарь загружается для каждого экземпляра
         * класса phpMorphy. Что приводит к очень медленной инициализации
         * phpMorphy и большому потреблению памяти (т.к. для каждого
         * запроса в память загружается порядка 10Mb, соответственно
         * при 10 одновременных запросах потребуется около 100Mb памяти.
         * Потому данный способ может быть полезен только для CLI скриптов.
         * Обратите внимание на директиву memory_limit в PHP, слишком низкое
         * значение может вызвать ошибку «Fatal error: Allowed memory size
         * of xxx bytes exhausted (tried to allocate xxx bytes)».
         *
         *          PHPMORPHY_STORAGE_SHM - скорость сравнима с PHPMORPHY_STORAGE_MEM,
         * однако словари загружаются в разделяемую память.
         * Это предпочтительный способ, однако необходимо наличие shmop
         * расширения, см. вывод php –m | grep shmop. phpMorphy загружает
         * все словари в один сегмент разделяемой памяти (см опцию shm),
         * поэтому необходимо установить размер сегмента таким образом,
         * чтобы все словари с которыми предполагается работать умещались в
         * данный сегмент (иначе возможны ошибки при иницализации:
         * «Can`t find free space for XXX block»)
         */
        'storage' => PHPMORPHY_STORAGE_FILE,
        /**
         *      Использовать предсказание путем отсечения префикса.
         * Для распознавания слов, образованных от известных путём
         * прибавления префиксов (популярный – мегапопулярный и т.п.)
         *
         *       Значение по умолчанию: TRUE
         *
         *       Допустимые значения: TRUE/FALSE
         */
        'predict_by_suffix' => TRUE,
        /**
         *  Использовать предсказание по окончанию

          Значение по умолчанию: TRUE

          Допустимые значения: TRUE/FALSE
         */
        'predict_by_db' => TRUE,
        /**
         *  использовать текстовое представление грамматической информации,
         * иначе используется значение констант из phpmorphy/src/gramtab_consts.php

          Значение по умолчанию: TRUE

          Допустимые значения: TRUE/FALSE
         */
        'graminfo_as_text' => TRUE,
        /**
         *  Позволяет ускорить процесс получения грамматической информации
         * (увеличивает потребление памяти во время исполнения и замедляет процесс инициализации)

          Значение по умолчанию: FALSE

          Допустимые значения: TRUE/FALSE
         */
        'use_ancodes_cache' => FALSE,
        /**
         * Устанавливает способ преобразования анкодов.

          Значение по умолчанию: phpMorphy::RESOLVE_ANCODES_AS_TEXT

          Допустимые значения:

          phpMorphy::RESOLVE_ANCODES_AS_INT - Используются числовые идентификаторы анкодов.
          phpMorphy::RESOLVE_ANCODES_AS_DIALING - Анкоды преобразуются к виду используемому
         * в словарях AOT. (двухбуквенное обозначение) |
          phpMorphy::RESOLVE_ANCODES_AS_TEXT - Развертывать анкод в текстовое представление.
         * Формат - ЧАСТЬ_РЕЧИ граммема1, граммема2, … |
         */
        'resolve_ancodes' => phpMorphy::RESOLVE_ANCODES_AS_TEXT,



        /**
         * Размер сегмента можно указать глобально. Для этого необходимо ДО
         * созданиния экземпляра phpMorphy объявить константу PHPMORPHY_SHM_SEGMENT_SIZE. т.е.

                require_once('.../common.php');
                ...
                define('PHPMORPHY_SHM_SEGMENT_SIZE', 32 * 1024 * 1024);
                ...
                $morphy = new phpMorphy(...);
                ...
                по умолчанию размер сегмента равен 24Mb
         */
        'shm' => array(
            // размер сегмента разделяемой памяти в байтах.
            // Предпочтительное значение: суммарный объем требуемых словарей + 10%.
            'segment_size'  => 0,
            'semaphore_key' => 0, // ключ для сегмента
            'segment_id'    => 0, // ключ для семафора
            'with_mtime'    => TRUE, // автоматически перегружать изменившиеся словари
            'no_lock'       => TRUE, // не использовать блокировку
        ),
    ),
);