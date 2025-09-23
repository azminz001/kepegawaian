<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockMaliciousInput
{
    public function handle(Request $request, Closure $next)
    {
        $excludedParams = ['uuid', 'token', 'description'];
        $patterns = [
            '/\b(select|union|insert|update|delete|drop|alter|exec|execute|sleep|benchmark|outfile|load_file)\b/i', // SQL Injection
            '/(\/\*|\*\/|--|#)/', // SQL comments
            '/\b(waitfor|delay|char|concat|convert|cast)\b/i', // SQL Timing Attacks
            '/\b(nslookup|cmd|bash|sh|wget|curl|file:\/\/|\/etc\/passwd|WEB-INF\/web.xml)\b/i', // Command Injection & File Access
            '/\b(script|iframe|object|embed|applet|form|input|button)\b/i', // XSS
            '/\b(base64_decode|eval|exec|system|passthru|shell_exec)\b/i', // PHP Code Injection
            '/\b(phpinfo|phpversion|ini_get|ini_set|error_reporting)\b/i', // PHP Function Abuse
            '/\b(ftp|ssh|telnet|sftp|scp)\b/i', // Remote Access Protocols
            '/\b(\\\|%5C|%2F|%5C%5C|%2F%2F)\b/i', // Directory Traversal
            '/\b(\\\'|\\\"|%27|%22|%3C|%3E|%3B|%3D)\b/i', // URL Encoding Attacks   
            '/\b(\\\x00|\\\x01|\\\x02|\\\x03|\\\x04|\\\x05|\\\x06|\\\x07|\\\x08|\\\x09|\\\x0A|\\\x0B|\\\x0C|\\\x0D|\\\x0E|\\\x0F)\b/i', // Null Byte Injection
            '/\b(\\\x20|\\\x21|\\\x22|\\\x23|\\\x24|\\\x25|\\\x26|\\\x27|\\\x28|\\\x29|\\\x2A|\\\x2B|\\\x2C|\\\x2D|\\\x2E|\\\x2F)\b/i', // Whitespace and Special Characters
            '/\b(\\\x30|\\\x31|\\\x32|\\\x33|\\\x34|\\\x35|\\\x36|\\\x37|\\\x38|\\\x39)\b/i', // Numeric Characters
            '/\b(\\\x3A|\\\x3B|\\\x3C|\\\x3D|\\\x3E|\\\x3F|\\\x40|\\\x41|\\\x42|\\\x43|\\\x44|\\\x45|\\\x46)\b/i', // Punctuation Characters
            '/\b(\\\x47|\\\x48|\\\x49|\\\x4A|\\\x4B|\\\x4C|\\\x4D|\\\x4E|\\\x4F|\\\x50|\\\x51|\\\x52)\b/i', // Uppercase Letters
            '/\b(\\\x53|\\\x54|\\\x55|\\\x56|\\\x57|\\\x58|\\\x59|\\\x5A|\\\x5B|\\\x5C|\\\x5D|\\\x5E)\b/i', // More Uppercase Letters
            '/\b(\\\x5F|\\\x60|\\\x61|\\\x62|\\\x63|\\\x64|\\\x65|\\\x66|\\\x67|\\\x68|\\\x69|\\\x6A)\b/i', // Lowercase Letters
            '/\b(\\\x6B|\\\x6C|\\\x6D|\\\x6E|\\\x6F|\\\x70|\\\x71|\\\x72|\\\x73|\\\x74|\\\x75|\\\x76)\b/i', // More Lowercase Letters
            '/\b(\\\x77|\\\x78|\\\x79|\\\x7A|\\\x7B|\\\x7C|\\\x7D|\\\x7E)\b/i', // Final Lowercase Letters
            '/\b(\\\x7F|\\\x80|\\\x81|\\\x82|\\\x83|\\\x84|\\\x85|\\\x86|\\\x87|\\\x88|\\\x89|\\\x8A)\b/i', // Control Characters
            '/\b(\\\x8B|\\\x8C|\\\x8D|\\\x8E|\\\x8F|\\\x90|\\\x91|\\\x92|\\\x93|\\\x94|\\\x95|\\\x96)\b/i', // More Control Characters
            '/\b(\\\x97|\\\x98|\\\x99|\\\x9A|\\\x9B|\\\x9C|\\\x9D|\\\x9E|\\\x9F)\b/i', // Final Control Characters
            '/\b(\\\xA0|\\\xA1|\\\xA2|\\\xA3|\\\xA4|\\\xA5|\\\xA6|\\\xA7|\\\xA8|\\\xA9|\\\xAA|\\\xAB)\b/i', // Extended ASCII Characters 
        ];

        if ($request->isMethod('post') || $request->isMethod('put')) {
            foreach ($request->all() as $key => $value) {
                if (in_array($key, $excludedParams)) {
                    continue; // Lewati parameter yang dikecualikan
                }
        
                if (is_string($value) && array_filter($patterns, fn($pattern) => preg_match($pattern, $value))) {
                    abort(403, 'Malicious input detected.');
                }
            }
        }

        return $next($request);
    }
}
