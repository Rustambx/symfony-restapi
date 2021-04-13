describe('User test', () => {
    beforeEach(() => {
        cy.viewport(1280, 720);
        cy.login();
    });
    it('User index', () => {
        cy.get('h1').should('contain', 'Hello');
        cy.get('[data-test=user]').click();
        cy.get('h1').should('contain', 'Users index');
    })

    it('User Edit', () => {
        cy.visit("user/edit/1");
        cy.get('h1').should('contain', 'Edit User');
        cy.get('[data-test=email]').clear();
        cy.get('[data-test=email]').type("admin@email.com");
        cy.get('[type="checkbox"]').uncheck();
        cy.get('[type="checkbox"]').check(['ROLE_ADMIN', 'ROLE_USER']);
        cy.get('[data-test=save]').click();
        cy.url().should('contain', '/user');
    })
})