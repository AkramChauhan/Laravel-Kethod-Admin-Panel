const pluralToSingular = (plural) => {
    // Remove non-alphabetic characters
    plural = plural.replace(/[^a-zA-Z]/g, "");

    // Convert to lowercase for case-insensitive processing
    plural = plural.toLowerCase();

    // Define common plural rules
    const rules = [
        [/(s)$/i, ""],
        [/((sh)es|ces|xes|zes)$/i, "$2"],
        [/((([^f])ves))$/i, "$2fe"],
        [/((ss))$/i, "$1"],
        [/((ies))$/i, "y"],
        [/(ies)$/i, "ie"],
        [/((ch|x)ies)$/i, "$1ie"],
        [/(ves)$/i, "fe"],
        [/(o)es$/i, "$1"],
        [/(us)es$/i, "$1s"],
        [/([^u])s$/i, "$1"],
    ];

    // Apply the rules to convert plural to singular
    for (const [pattern, replacement] of rules) {
        if (pattern.test(plural)) {
            return plural.replace(pattern, replacement);
        }
    }

    // If no rule matched, return the original word
    return plural;
};
