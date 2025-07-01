<?php

function format_rupiah($number)
{
    return 'Rp ' . number_format($number, 0, ',', '.');
}
