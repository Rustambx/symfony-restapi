// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })
import 'cypress-file-upload';

Cypress.Commands.add('login', () => {
    cy.visit("http://localhost:8088/login");
    cy.url().should('contain', '/login');
    cy.get('[data-test=email]').type("admin@email.com").should('have.value', "admin@email.com");
    cy.get('[data-test=password]').type("admin123").should('have.value', "admin123");
    cy.get('[data-cy=login]').click();
    cy.get('[data-test=home]').contains('Home');
    cy.get('[data-test=home]').focus();
    cy.get('[data-test=user]').contains('Users');
    cy.get('[data-test=user]').focus();
    cy.get('[data-test=post]').contains('Posts');
    cy.get('[data-test=post]').focus();
    cy.get('[data-test=logout]').contains('Logout');
    cy.get('[data-test=logout]').focus();
})
