<?php
namespace 
{
    const IS_DEVELOPMENT = true;
    const VISUAL_DEBUGGER_ENABLED = true;
    const CONSOLE_DEBUGGER_ENABLED = true;
    const AJAX_DEBUGGER_ENABLED = true;
    const FILE_DEBUGGER_ENABLED = true;

    \KrupaBOX\Internal\Engine::includeInsensitive(__KRUPA_PATH_INTERNAL__ . "Internal/Kernel.php");
}

namespace
{
    class KrupaBOX
    {
        const TYPE    = "beta";
        const VERSION = "1.0.0.1";
    }
}

