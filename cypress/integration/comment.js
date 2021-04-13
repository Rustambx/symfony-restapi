describe('Comment test', () => {
    beforeEach(() => {
        cy.viewport(1280, 720);
        cy.login();
    });
    it('Comment create', () => {
        cy.visit("/post/1/comments");
        cy.get('[data-test=content]').type("Lorem Ipsum has been the industry's standard dummy text");
        cy.get('[data-test=save]').click();
        cy.url().should('contain', '/post/1/comments');
    })
})