module.exports = {
    platform: 'github',
    logLevel: 'debug',
    onboardingConfig: {
        extends: ['config:base'],
    },
    repositories: ['vasary/tac-core'],
    includeForks: true,
    gitAuthor: "Renovate bot <bot@renovate.io>",
    username: "renovate",
    onboarding: false,
    printConfig: true,
    requireConfig: "optional"
};
